<?php
/**
 * Created by PhpStorm.
 * User: Morphinof
 * Date: 12/04/2018
 * Time: 20:53
 */

namespace BulkImports\Command;

use BulkImports\Annotations\ExtractableAnnotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class GenerateCsvCommand extends ContainerAwareCommand
{
    const NAME = 'bulk-imports:generate:csv:users';
    const DESCRIPTION = 'Generates a csv file with randoms users with a contact to import, by default will be randomized between %s and %s';

    const DELIMITER = ';';
    const OUTPUT_FOLDER = __DIR__ . '/../../tmp';

    const ARG_NUMBER_OF_USERS = 'arg-number-of-users';
    const DSC_NUMBER_OF_USERS = 'The number of users generate, max value is %s';

    const ARG_OUTPUT_FILENAME = 'arg-output-filename';
    const DSC_OUTPUT_FILENAME = 'The output file name, if none the name will be generated';

    const OPT_WITH_CONTACT = 'opt-with-contact';
    const SHO_WITH_CONTACT = 'c';
    const DSC_WITH_CONTACT_SHORTCUT = 'Generates users with a contact object linked';

    const OUTPUT_FILENAME_PREFIX = 'list-of-users';
    const MIN_NUMBER_OF_USERS = 1;
    const MAX_NUMBER_OF_USERS = 1000000000;

    /** @var InputInterface $input */
    protected $input;

    /** @var OutputInterface $output */
    protected $output;

    /** @var AnnotationReader $reader */
    protected $reader;

    /** @var  $output */
    protected $serializer;

    /** @var int $numberOfUsers */
    protected $numberOfUsers = 0;

    /** @var string outputFilename */
    protected $outputFilename = null;

    /** @var array $users */
    protected $users = [];

    /**
     * GreetCommand constructor.
     *
     * @param null|string $name
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(?string $name = null)
    {
        parent::__construct($name);

        $this->reader     = $reader = new AnnotationReader();
        $this->serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder(self::DELIMITER)]);
    }

    protected function configure(): void
    {
        $this
            ->setName(self::NAME)
            ->setDescription(sprintf(self::DESCRIPTION, self::MIN_NUMBER_OF_USERS, self::MAX_NUMBER_OF_USERS))
            ->addArgument(
                self::ARG_OUTPUT_FILENAME,
                InputArgument::OPTIONAL,
                sprintf(self::DSC_OUTPUT_FILENAME)
            )
            ->addArgument(
                self::ARG_NUMBER_OF_USERS,
                InputArgument::OPTIONAL,
                sprintf(self::DSC_NUMBER_OF_USERS, self::MAX_NUMBER_OF_USERS)
            )
            ->addOption(
                self::OPT_WITH_CONTACT,
                self::SHO_WITH_CONTACT,
                null,
                self::DSC_WITH_CONTACT_SHORTCUT
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    private function init(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', -1);
        set_time_limit(0);

        $this->input  = $input;
        $this->output = $output;
    }

    /**
     * Execute the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->init($input, $output);

        $data = $this->generateUsers();
        $data = $this->serializer->encode($data, 'csv');

        $path = sprintf('%s/%s', self::OUTPUT_FOLDER, $this->outputFilename);
        file_put_contents($path, $data);

        $this->output->writeln(sprintf('File %s generated !', $this->outputFilename));
    }

    /**
     * @return array
     */
    protected function generateUsers(): array
    {
        $users = [];

        return $users;
    }

    /**
     * @return array
     */
    protected function generateContact(): array
    {
        $contact = [];

        return $contact;
    }

    /**
     * @param string $class
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function extractClassProperties(string $class): array
    {
        $reflectionClass = new \ReflectionClass($class);
        $properties      = [];

        foreach ($reflectionClass->getProperties() as $property) {
            $properties[] = $property;
        }

        return $properties;
    }

    /**
     * Get the extractable properties of an entity
     *
     * @param string $class
     *
     * @return array
     * @throws \Exception
     * @throws \ReflectionException
     */
    protected function getExtractableProperties(string $class): array
    {
        $reflectionClass = new \ReflectionClass($class);

        $annotation = $this->reader->getClassAnnotation($reflectionClass, ExtractableAnnotation::class);

        if (!$annotation) {
            throw new \Exception(
                sprintf(
                    'Entity class %s does not have required annotation %s',
                    $class,
                    ExtractableAnnotation::class
                )
            );
        }

        dump($annotation);
    }

    /**
     * Get the command arguments
     */
    protected function getArguments(): void
    {
        $this->numberOfUsers  = $this->input->getArgument(self::ARG_NUMBER_OF_USERS) ?? range(self::MIN_NUMBER_OF_USERS, self::MAX_NUMBER_OF_USERS);
        $this->outputFilename = $this->input->getArgument(self::ARG_OUTPUT_FILENAME) ?? uniqid(self::OUTPUT_FILENAME_PREFIX, true);
    }
}