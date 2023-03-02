<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<script type="importmap">
    {
        "imports": {
            "three": "/three.js",
            "OBJLoader": "/OBJLoader.js",
            "GLTFLoader": "/GLTFLoader.js"
        }
    }
</script>

{{--<script type="module">--}}
{{--    import {Scene, PerspectiveCamera, WebGLRenderer} from "three";--}}
{{--    import {OBJLoader} from 'OBJLoader'--}}

{{--    const loader = new OBJLoader()--}}

{{--    const scene = new Scene();--}}
{{--    const camera = new PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );--}}

{{--    const renderer = new WebGLRenderer();--}}
{{--    renderer.setSize( window.innerWidth, window.innerHeight );--}}
{{--    document.body.appendChild( renderer.domElement );--}}


{{--    loader.load(--}}
{{--        '/qwer.obj',--}}
{{--        function ( object ) {--}}

{{--            scene.add( object );--}}

{{--        },--}}
{{--        // called when loading is in progresses--}}
{{--        function ( xhr ) {--}}

{{--            console.log( ( xhr.loaded / xhr.total * 100 ) + '% loaded' );--}}

{{--        },--}}
{{--        // called when loading has errors--}}
{{--        function ( error ) {--}}

{{--            console.log( 'An error happened' );--}}

{{--        }--}}
{{--    );--}}
{{--</script>--}}

<script type="module">
    import {Scene, PerspectiveCamera, WebGLRenderer} from "three";
    import {GLTFLoader} from 'GLTFLoader'

    const scene = new Scene();
    const camera = new PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );

    const renderer = new WebGLRenderer();
    renderer.setSize( window.innerWidth, window.innerHeight );
    document.body.appendChild( renderer.domElement );


    const loader = new GLTFLoader();

    loader.load( '/model.glb', function ( gltf ) {
        scene.add( gltf.scene );

    }, undefined, function ( error ) {

        console.error( error );

    } );
</script>

</body>
</html>
