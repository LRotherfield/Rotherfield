<?php

namespace Rothers\UserExtensionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Role\Role;
use JMS\SecurityExtraBundle\Security\Authentication\Token\RunAsUserToken;

class CustomerControllerTest extends WebTestCase
{

    private $_container;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_container = $kernel->getContainer();
    }

    private function getAuthenticatedUser()
    {
        $client = static::createClient();
        $firewall = $this->_container->getParameter('security.firewall.name');
        $client->getCookieJar()->set(new \Symfony\Component\BrowserKit\Cookie(session_name(), true));
        $token = new UsernamePasswordToken('user', null, $firewall, array('ROLE_ADMIN'));
        self::$kernel->getContainer()->get('session')->set('_security_' . $firewall, serialize($token));

        return $client;
    }

    public function testCompleteScenario()
    {

        echo "\n\n ===START CUSTOMER TEST===\n\n";

        // Create a new client to browse the application
        $client = $this->getAuthenticatedUser();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/user/customer/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());

        echo "The index page exists.\n";

        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form();

        $form['userextensionbundle_customertype[user][username]'] = 'functional@test.com';
        $form['userextensionbundle_customertype[user][password][Password]'] = 'test1ng';
        $form['userextensionbundle_customertype[user][password][Repeat Password]'] = 'testing';
        $form['userextensionbundle_customertype[first_name]'] = 'FunctionalFirstName';
        $form['userextensionbundle_customertype[last_name]'] = 'Test';

        $client->submit($form);

        $this->assertRegExp('/The passwords do not match/', $client->getResponse()->getContent());

        echo "The repeat password check works.\n";

        $form['userextensionbundle_customertype[user][password][Password]'] = 'testing';
        $form['userextensionbundle_customertype[user][password][Repeat Password]'] = 'testing';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('tr:contains("First_name")')->filter('td:contains("Functional")')->count() == 1, 'No first name shown or not redirected to show page');

        echo "User created.\n";

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form();
        $form['userextensionbundle_customertype[user][password][Password]'] = 'testing';
        $form['userextensionbundle_customertype[user][password][Repeat Password]'] = 'testing';
        $form['userextensionbundle_customertype[last_name]'] = 'Test2';

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('[value="Test2"]')->count() == 1);

        echo "Edit successful.\n";

        // Check user has been created with correct role
        $user_crawler = $client->request('GET', '/admin/user/');
        $this->assertTrue($user_crawler->filter('tr:contains("functional@test.com")')->filter('td:contains("customer")')->count() == 1, 'No user created or has wrong role');

        echo "User exists and has correct role\n";

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/FunctionalFirstName/', $client->getResponse()->getContent());

        echo "Entity successfully deleted.\n";

        $crawler = $client->request('GET', '/agent/customer/new');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());

        echo "The create customer page exists.\n";

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form();
        $form['userextensionbundle_customertype[email]'] = 'functional@test.com';
        $form['userextensionbundle_customertype[first_name]'] = 'FunctionalFirstName';
        $form['userextensionbundle_customertype[last_name]'] = 'Test';

        $client->submit($form);
        
        $crawler = $client->followRedirect();
        
        $em = $this->_container->get('doctrine.orm.entity_manager');
        $customer = $em->getRepository('UserExtensionBundle:Customer')->findOneBy(array('email' => 'functional@test.com'));
        
        $crawler = $client->request('GET', "/admin/user/customer/{$customer->getId()}/show");
        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        
        echo "The customer show page exists.\n";
        
        $this->assertRegExp('/Create User Account/', $client->getResponse()->getContent());
        
        echo "The customer does not have a user account yet.\n";
        
        $crawler = $client->click($crawler->selectLink('Create User Account')->link());
        
        $this->assertNotRegExp('/Create User Account/', $client->getResponse()->getContent());
        
        $user_crawler = $client->request('GET', '/admin/user/');
        $this->assertTrue($user_crawler->filter('tr:contains("functional@test.com")')->filter('td:contains("customer")')->count() == 1, 'No user created or has wrong role');
        
        echo "The customer now has a user account.\n";
        
        $crawler = $client->request('GET', "/admin/user/customer/{$customer->getId()}/edit");
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();        
        
        // Check the entity has been delete on the list
        $this->assertNotRegExp('/FunctionalFirstName/', $client->getResponse()->getContent());

        echo "Entity successfully deleted.\n";

        echo "\n\n ===END CUSTOMER TEST===\n\n";
    }

}