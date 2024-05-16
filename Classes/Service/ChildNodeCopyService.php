<?php

namespace Litefyr\Templates\Service;

use Flowpack\NodeTemplates\Service\EelEvaluationService;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Eel\Package as EelPackage;
use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\NodeOperations;

class ChildNodeCopyService
{
    #[Flow\Inject]
    protected EelEvaluationService $eelEvaluationService;

    #[Flow\Inject]
    protected NodeOperations $nodeOperations;

    /**
     * @param NodeInterface $node
     * @param array<mixed, mixed> $context
     * @param array{childNodesToCopy?: string} $options
     * @return void
     */
    public function copyChildNodesAfterTemplateApplication(NodeInterface $node, array $context, array $options): void
    {
        // Copy child nodes from template
        if (
            isset($options['childNodesToCopy']) &&
            preg_match(EelPackage::EelExpressionRecognizer, $options['childNodesToCopy'])
        ) {
            $childNodes = $this->eelEvaluationService->evaluateEelExpression($options['childNodesToCopy'], $context);
            /** @var NodeInterface $childNode */
            foreach ($childNodes as $childNode) {
                $this->nodeOperations->copy($childNode, $node, 'into');
            }
        }
    }
}
