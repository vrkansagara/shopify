<?php
require_once  __DIR__ . '/../vendor/autoload.php';

use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\DocBlock\Tag;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\PropertyGenerator;

$classDirectory = __DIR__ .'/Classes';
$jsonDirectory = __DIR__ .'/Json/';

$recursiveDirectoryIterator = new RecursiveDirectoryIterator($jsonDirectory);
$files= [];
foreach ( $recursiveDirectoryIterator as $directoryIterator){
    $fileName = $directoryIterator->getFilename();
    $fullPath = $directoryIterator->__toString ();
    if ($directoryIterator->isFile () && strtolower($directoryIterator->getExtension()) == 'json') {
        $files [$fullPath] = $directoryIterator;
    }
    if ($directoryIterator->isDir() && !in_array($fileName,['.','..'])){
        $recursiveDirectoryIteratorInternal = new RecursiveDirectoryIterator($fullPath);

        $fileName = $directoryIterator->getFilename();
        $fullPath = $directoryIterator->__toString ();

        foreach ($recursiveDirectoryIteratorInternal as $directoryIteratorInternal){
            if ($directoryIteratorInternal->isFile () && strtolower($directoryIteratorInternal->getExtension()) == 'json') {
                $files [$directoryIteratorInternal->__toString ()] = $directoryIteratorInternal;
            }
        }
    }
}

foreach ($files as $fileFullPath => $fileSplInfo){
    $json = json_decode(file_get_contents($fileFullPath),1);
    $fileInfo = new SplFileInfo($fileFullPath);


    $className = $fileInfo->getBasename('.json');


// Configuring after instantiation
    $method = new Laminas\Code\Generator\MethodGenerator();
    $method->setName('hello')->setBody('echo \'Hello world!\';');

    $docblock = Laminas\Code\Generator\DocBlockGenerator::fromArray([
        'shortDescription' => 'Sample generated class',
        'longDescription'  => 'This is a class generated with Laminas\Code\Generator.',
        'tags'             => [
            [
                'name'        => 'version',
                'description' => '$Rev:$',
            ],
            [
                'name'        => 'license',
                'description' => 'New BSD',
            ],
        ],
    ]);


    $properties = [
//    ['bar', 'baz', PropertyGenerator::FLAG_PROTECTED],
//    ['baz', 'bat', PropertyGenerator::FLAG_PUBLIC]
    ];
    $methods= [];
    foreach ($json as $key => $value){
        $properties[] = [$key,$value,PropertyGenerator::FLAG_PUBLIC];
        $dataType = 'string';
        switch (gettype($key)){
            case is_bool($key):
                $dataType = 'boolean';
            case is_string($key):
            case is_array($key):
                $dataType = 'string';
        }

        $methods[] =         MethodGenerator::fromArray([
            'name'       => sprintf("set%s",ucfirst($key)),
            'parameters' => [$key],
            'body'       => sprintf('$this->%s = $%s;' . "\n" . 'return $this;',$key,$key),
            'docblock'   => DocBlockGenerator::fromArray([
                'shortDescription' => sprintf('Set the %s property',$key),
                'longDescription'  => 'null',
                'tags'             => [
                    new Tag\ParamTag(
                        $key,
                        [
                            $dataType
                        ],
                        sprintf("Set value of %s",$key)
                    ),
                    new Tag\ReturnTag([
                        'datatype'  => $dataType,
                    ]),
                ],
            ]),
        ]);
        $methods[] =          // Method passed as concrete instance
            new MethodGenerator(
                sprintf('get%s',ucfirst($key)),
                [],
                MethodGenerator::FLAG_PUBLIC,
                sprintf('return $this->%s;',$key),
                DocBlockGenerator::fromArray([
                    'shortDescription' => sprintf('Retrieve the %s property',$key),
                    'longDescription'  => sprintf('Retrieve the %s property',$key),
                    'tags'             => [
                        new Tag\ReturnTag([
                            'datatype'  => sprintf('%s|null',$key),
                        ]),
                    ],
                ])
            );

    }
    $class = new Laminas\Code\Generator\ClassGenerator();
    $class->setName($className)
        ->setDocblock($docblock)
        ->addProperties($properties)
        ->addMethods($methods)
//    ->addConstants([['bat',  'foobarbazbat']])
//    ->addMethodFromGenerator($method)
    ;

    $file = new Laminas\Code\Generator\FileGenerator();
    $file->setClass($class);

// or write it to a file:
    file_put_contents(sprintf("%s/%s.php",$classDirectory,$className), $file->generate());
}