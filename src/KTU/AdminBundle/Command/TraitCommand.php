<?php
namespace KTU\AdminBundle\Command;

use KTU\AppBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TraitCommand extends AbstractCommand
{
    public function configure()
    {
        $this->setName('generate:trait');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $twig \Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine */
        /* @var $kernel \AppKernel */
        $twig = $this->getContainer()->get('templating');
        $kernel = $this->getContainer()->get('kernel');
        $bundles = $kernel->getBundles();
        $appBundle = $bundles['KTUAppBundle'];
        $namespace = $appBundle->getNamespace() . '\\' . 'Traits';
        $methods = $this->getMethods();
        $name = 'ModelTrait';

        $destination = getPath($appBundle->getPath(), 'Traits', $name . '.php');

        $trait = $twig->render('KTUAdminBundle:generator:trait.php.twig', [
                'trait' => $name,
                'namespace' => $namespace,
                'methods' => $methods,
            ]);

        file_put_contents($destination, $trait);
    }

    protected function getMethods()
    {
        $services = $this->getContainer()->getServiceIds();
        $result = [];

        foreach($services as $serviceName) {
            $parts = explode('.', $serviceName);
            if(end($parts) != 'model') continue;

            $service = $this->getContainer()->get($serviceName);

            $class = '\\' . get_class($service);
            $classParts = explode('\\', $class);
            $method = 'get' . end($classParts);
            $result[] = [
                'class' => $class,
                'method' => $method,
                'service' => $serviceName
            ];
        }

        return $result;
    }
} 