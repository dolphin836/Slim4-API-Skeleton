<?php
// 生成随机用户
namespace Dolphin\Ting\Http\Command;

use Dolphin\Ting\Http\Constant\UserConstant;
use Dolphin\Ting\Http\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Container\ContainerInterface as Container;
use DateTime;

class GenerateRandomUserCommand extends Command
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container, string $name = null)
    {
        parent::__construct($name);

        $this->container = $container;
    }

    // 命令
    protected static $defaultName = 'generate-random-user';

    protected function configure ()
    {
        $this->setDescription('Generate User.')
             ->addArgument('count', InputArgument::REQUIRED, 'User Count.');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count');

        for ($i = 0; $i < $count; $i++) {
            $username = $this->generateRandomUser();
            $output->writeln('Username:' . $username);
            sleep(1);
        }

        return 0;
    }

    private function generateRandomUser ()
    {
        $entityManager = $this->container->get('EntityManager');

        $username = 'User' . date('YmdHis') . rand(100, 999);

        $user     = new User();
        $user->setUsername($username);
        $user->setPassword(UserConstant::DEFAULT_PASSWORD);
        $user->setLastSignInTime(new DateTime());

        $entityManager->save($user);

        return $username;
    }
}