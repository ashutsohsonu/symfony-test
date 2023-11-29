<?php



namespace App\EventListener;

use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSuccessListener implements EventSubscriberInterface
{
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param InteractiveLoginEvent $event
     * @return void
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the user from the event
        $user = $event->getAuthenticationToken()->getUser();

        // Log the successful login
        $this->logger->log('INFO','User ' . $user->getUsername() . ' has logged in successfully.');
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.interactive_login' => 'onSecurityInteractiveLogin',
        ];
    }
}
