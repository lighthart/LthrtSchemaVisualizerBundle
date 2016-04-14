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
    public function dagreAction(Request $request, $depth = 0, $class = null)
    {
        $adjacencyList = $this->get('lthrt_schema_visualizer.representation_service')->getAdjacencyListJSON($class, $depth);
        $json          = $this->get('lthrt_schema_visualizer.representation_service')->getNodesAndEdges($class);

        return $this->render('LthrtSchemaVisualizerBundle:Schema:dagre.html.twig', [
            'adjacencyList' => $adjacencyList,
            'class'         => $class,
            'depth'         => $depth,
            'json'          => $json,
        ]);
    }

    public function graphAction(Request $request, $depth = 0, $class = null)
    {
        $adjacencyList = $this->get('lthrt_schema_visualizer.representation_service')->getAdjacencyListJSON($class, $depth);

        return $this->render('LthrtSchemaVisualizerBundle:Schema:graph.html.twig', [
            'adjacencyList' => $adjacencyList,
            'class'         => $class,
            'depth'         => $depth,
        ]);
    }

    public function graphmlAction(Request $request, $depth = 0, $class = null)
    {
        $json = $this->get('lthrt_schema_visualizer.representation_service')->getNodesAndEdges($class);

        return $this->render('LthrtSchemaVisualizerBundle:Schema:graphml.html.twig', [
            'json'  => $json,
            'class' => $class,
            'depth' => $depth,
        ]);
    }

    public function jsonAction(Request $request, $depth = 0, $class = null)
    {
        $json          = $this->get('lthrt_schema_visualizer.representation_service')->getJSON($class);
        $adjacencyList = $this->get('lthrt_schema_visualizer.representation_service')->getAdjacencyListJSON($class, $depth);

        return $this->render('LthrtSchemaVisualizerBundle:Schema:json.html.twig', [
            'json'          => $json,
            'class'         => $class,
            'adjacencyList' => $adjacencyList,
            'depth'         => $depth,
        ]);
    }

    public function listAction(Request $request)
    {
        $classes = array_map(function ($m) {return str_replace('\\', '_', $m->getName());},
            $this->getDoctrine()->getManager()->getMetadataFactory()->getAllMetadata()
        );

        return $this->render('LthrtSchemaVisualizerBundle:Schema:list.html.twig', ['classes' => $classes]);
    }
}
