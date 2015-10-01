<?php

namespace Lthrt\SchemaVisualizerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

//
// Contact controller.
//
//

class SchemaController extends Controller
{
    public function allAction(Request $request)
    {
        $rep  = $this->get('lthrt_schema_visualizer.representation_service');
        $json = $rep->getAllJSON();

        return $this->render('LthrtSchemaVisualizerBundle:Schema:single.html.twig', ['json' => $json]);
    }

    public function graphAction(Request $request)
    {
        $rep  = $this->get('lthrt_schema_visualizer.representation_service');
        $json = $rep->getGraphJSON();

        return $this->render('LthrtSchemaVisualizerBundle:Schema:graph.html.twig', ['json' => $json]);
    }

    public function listAction(Request $request)
    {
        $classes = array_map(function ($m) {return str_replace('\\', '_', $m->getName());},
            $this->getDoctrine()->getManager()->getMetadataFactory()->getAllMetadata()
        );

        return $this->render('LthrtSchemaVisualizerBundle:Schema:list.html.twig', ['classes' => $classes]);
    }

    public function singleAction(Request $request, $class)
    {
        $rep  = $this->get('lthrt_schema_visualizer.representation_service');
        $json = $rep->getJSON($class);

        return $this->render('LthrtSchemaVisualizerBundle:Schema:single.html.twig', ['json' => $json]);
    }
}
