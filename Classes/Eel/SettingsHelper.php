<?php

namespace Litespeed\Templates\Eel;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Carbon\Eel\EelHelper\BackendHelper;

class SettingsHelper implements ProtectedContextAwareInterface
{
    #[Flow\Inject]
    protected BackendHelper $backendHelper;

    /**
     * Returns options config from a node
     *
     * @param NodeInterface $node
     * @return array
     */
    public function options(NodeInterface $node, $key): string
    {
        $value =
            $node->getNodeType()->getFullConfiguration()['options'][$key] ?? '';
        $array = explode(':', $value);
        if (count($array) !== 3) {
            return $value;
        }
        return $this->backendHelper->translate(
            $array[2],
            null,
            [],
            $array[1],
            $array[0]
        );
    }

    /**
     * Allow call of methods
     *
     * @param string $methodName
     * @return void
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
