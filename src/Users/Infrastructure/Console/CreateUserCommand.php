<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Console;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'app:users:create-user',
    description: 'Create a new user',
)]
final class CreateUserCommand extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask(
            'email', // question
            null, // default
            function (?string $input) {
                Assert::email($input, 'Email is invalid'); // error message if email is not valid

                return $input; // return email if it's valid
            }
        );

        $password = $io->askHidden(
            'password', // question
            function (?string $input) {
                Assert::notEmpty($input, 'Password can not be empty'); // check if password is provided

                return $input; // return password if it's provided
            }
        );

        $user = $this->userFactory->create($email, $password); // create user using factory
        $this->userRepository->add($user); // add user to repository

        return Command::SUCCESS;
    }
}
