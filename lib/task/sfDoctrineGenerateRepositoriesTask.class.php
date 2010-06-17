<?php

require_once(dirname(__FILE__).'/sfDoctrineBaseTask.class.php');

class sfDoctrineGenerateRepositoriesTask extends sfDoctrineBaseTask
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
    $this->name = 'generate-repositories';
    $this->briefDescription = 'Generate the Doctrine repositories classes';

    /*
    Arguments:
    dest-path               The path to generate your repository classes.

    Options:
    --regenerate-repositories Flag to define if generator should regenerate repository if it exists. (default: )

    Help:
    Generate repository classes and method stubs from your mapping information.
     */

    $this->detailedDescription = <<<EOF
The [doctrine:version|INFO] generates the Doctrine repository clases using your configured repository directory

  [./symfony doctrine:generate-repositories|INFO]

EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $args[] = sfConfig::get('sf_lib_dir').DIRECTORY_SEPARATOR.'entities'.DIRECTORY_SEPARATOR.'doctrine';

    $em = false; // Do not generate from database
    $this->callDoctrineCli('orm:generate-repositories', $args, $em);
  }
}