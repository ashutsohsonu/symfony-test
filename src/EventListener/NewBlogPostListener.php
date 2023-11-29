<?php


namespace App\EventListener;

use App\Entity\Blog;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NewBlogPostListener implements EventSubscriberInterface
{
    private $mailer;
    private $adminEmail;

    public function __construct(MailerInterface $mailer, string $adminEmail)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // Check if the entity is a Blog
        if ($entity instanceof Blog) {
            // Send email notification to the admin
            $this->sendNotificationEmail($entity);
        }
    }

    private function sendNotificationEmail(Blog $blogPost)
    {
        $subject = 'New Blog Created';
        $content = sprintf('A new blog post has been created: %s', $blogPost->getTitle());

        $email = (new Email())
            ->from('noreply@example.com')
            ->to($this->adminEmail)
            ->subject($subject)
            ->text($content);
        $this->mailer->send($email);
    }

    public static function getSubscribedEvents()
    {
        return [
            'postPersist' => 'postPersist',
        ];
    }
}
