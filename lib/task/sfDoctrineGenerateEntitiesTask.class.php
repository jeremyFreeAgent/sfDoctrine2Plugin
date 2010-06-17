<?php

require_once(dirname(__FILE__).'/sfDoctrineBaseTask.class.php');

class sfDoctrineGenerateEntitiesTask extends sfDoctrineBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->aliases = array();
    $this->namespace = 'doctrine';
    $this->name = 'generate-entities';
    $this->briefDescription = 'Generate the Doctrine entities classes';

    /*
    Arguments:
    dest-path               The path to generate your entity classes.

    Options:
    --regenerate-entities Flag to define if generator should regenerate entity if it exists. (default: )

    Help:
    Generate entity classes and method stubs from your mapping information.
     */

    $this->detailedDescription = <<<EOF
The [doctrine:version|INFO] generates the Doctrine proxy clases using your configured proxy directory

  [./symfony doctrine:generate-entities|INFO]

EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $options['extend'] = 'sfDoctrineActiveEntity';
    $options['num-spaces'] = 2;
    $options['generate-annotations'] = true;

    $keys = array('generate-annotations', 'extend', 'num-spaces');
    $args = $this->prepareDoctrineCliArguments($options, $keys);
    $args[] = sfConfig::get('sf_lib_dir').DIRECTORY_SEPARATOR.'entities'.DIRECTORY_SEPARATOR.'doctrine';

    $em = false; // Do not generate from database
    $this->callDoctrineCli('orm:generate-entities', $args, $em);
  }
}