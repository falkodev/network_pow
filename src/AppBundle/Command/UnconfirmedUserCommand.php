<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UnconfirmedUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:users:unconfirmed')
            ->setDescription('Disable all unconfirmed users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container   = $this->getContainer();
        $userManager = $container->get('app.manager.user');

        $users = $userManager->getAllUnconfirmedAccount($container->getParameter('user_days_to_confirm_account'));

        foreach ($users as $user) {
            $user->setStatus(User::STATUS_BLOCKED);
            $userManager->persist($user);

            $output->writeln(sprintf("<info>User %s was blocked</info>", $user->getEmail()));
        }

        if (null !== $users) {
            $userManager->flush();
        }
    }
}
