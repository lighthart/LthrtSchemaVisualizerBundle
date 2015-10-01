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
        $json = $this->get('lthrt_schema_visualizer.representation_service')->getAllJSON();

        return $this->render('LthrtSchemaVisualizerBundle:Schema:single.html.twig', ['json' => $json]);
    }

    public function allGraphAction(Request $request)
    {
        $json = $this->get('lthrt_schema_visualizer.representation_service')->getAllGraphJSON();

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
        $json  = $this->get('lthrt_schema_visualizer.representation_service')->getJSON($class);

        return $this->render('LthrtSchemaVisualizerBundle:Schema:single.html.twig', ['json' => $json]);
    }

    public function singleGraphAction(Request $request, $class)
    {
        $json  = $this->get('lthrt_schema_visualizer.representation_service')->getGraphJSON($class);

        return $this->render('LthrtSchemaVisualizerBundle:Schema:graph.html.twig', ['json' => $json, 'class' => $class]);
    }
}
