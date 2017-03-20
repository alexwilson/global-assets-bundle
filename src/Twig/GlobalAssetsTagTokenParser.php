<?php

namespace antoligy\GlobalAssetsBundle\Twig;

use Twig_TokenParser;
use Twig_Node_Block;
use Twig_Node;
use Twig_Node_Expression_Function;
use Twig_Node_Expression_Constant;
use Twig_Node_Expression_Array;
use Twig_Node_Print;
use Twig_Token;

class GlobalAssetsTagTokenParser extends Twig_TokenParser
{
    public function parse(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(Twig_Token::NAME_TYPE)->getValue();

        if ($this->parser->hasBlock($name)) {
            throw new Twig_Error_Syntax(sprintf("The block '%s' has already been defined line %d.", $name, $this->parser->getBlock($name)->getTemplateLine()), $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }

        $this->parser->setBlock($name, $block = new Twig_Node_Block($name, new Twig_Node(array()), $lineno));
        $this->parser->pushLocalScope();
        $this->parser->pushBlockStack($name);

        if ($stream->nextIf(Twig_Token::BLOCK_END_TYPE)) {
            $body = $this->parser->subparse(array($this, 'decideGlobalAssetsEnd'), true);
            if ($token = $stream->nextIf(Twig_Token::NAME_TYPE)) {
                $value = $token->getValue();
                if ($value != $name) {
                    throw new Twig_Error_Syntax(sprintf('Expected endglobalassets for block "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
                }
            }
        } else {
            $body = new Twig_Node(array(
                new Twig_Node_Print($this->parser->getExpressionParser()->parseExpression(), $lineno),
            ));
        }

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $block->setNode('body', $body);
        $this->parser->popBlockStack();
        $this->parser->popLocalScope();

        $filename = $stream->getSourceContext()->getName();

        return new Twig_Node([
            new Twig_Node_Print(
                new Twig_Node_Expression_Function('render_esi', new Twig_Node([
                    new Twig_Node_Expression_Function('controller', new Twig_Node([
                        new Twig_Node_Expression_Constant('global_assets:assetsAction', $lineno),
                        new Twig_Node_Expression_Array([
                            new Twig_Node_Expression_Constant('blk', $lineno),
                            new Twig_Node_Expression_Constant($name, $lineno),
                            new Twig_Node_Expression_Constant('tpl', $lineno),
                            new Twig_Node_Expression_Constant($filename, $lineno)
                        ], $lineno)
                    ]), $lineno
                )]), $lineno
            ), $lineno)
        ]);
    }

    public function decideGlobalAssetsEnd(Twig_Token $token)
    {
        return $token->test('endglobalassets');
    }

    public function getTag()
    {
        return 'globalassets';
    }
}


