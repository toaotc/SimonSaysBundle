<?php

namespace Toa\Bundle\SimonSaysBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SimonSaysDataCollector
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class SimonSaysDataCollector extends DataCollector
{
    /** @var array */
    private $catalogues;

    /**
     * Constructor
     *
     * @param array $catalogues
     */
    public function __construct($catalogues = array())
    {
        $this->catalogues = $catalogues;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $keys = array_keys($this->catalogues);

        $randomIndex = array_rand($keys);
        $randomKey = $keys[$randomIndex];
        $catalogue = $this->catalogues[$randomKey];

        $this->data['catalogue'] = ucfirst($randomKey);
        $this->data['saying'] = $catalogue[array_rand($catalogue)];
    }

    /**
     * get saying
     *
     * @return string
     */
    public function getSaying()
    {
        return $this->data['saying'];
    }

    /**
     * get saying
     *
     * @return string
     */
    public function getCatalogue()
    {
        return $this->data['catalogue'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'saying';
    }
}
