<template>
    <div id="container"></div>
</template>

<script>
import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls";
import {
    Lensflare,
    LensflareElement
} from "three/examples/jsm/objects/Lensflare.js";

const texPath = "storage/web/tex/";
const earthDayMap = texPath + "earth_daymap.jpg";
const earthNormalMap = texPath + "earth_normal_map.jpg";
const earthSpecularMap = texPath + "earth_specular_map.jpg";
const earthClouds = texPath + "earth_cloudmap.jpg";
const lensFlare0 = texPath + "flare-01.jpg";
const lensFlare3 = texPath + "lensflare3.png";

export default {
    name: "Earth",
    data() {
        return {
            camera: null,
            scene: null,
            renderer: null,
            controls: null,
            clock: null,
            geometry: null,
            meshPlanet: null,
            meshClouds: null,
            radius: 50,
            tilt: 0.21,
            rotationSpeed: 0.0009,
            cloudsScale: 1.005
        };
    },
    methods: {
        init() {
            let container = document.getElementById("container");
            const textureLoader = new THREE.TextureLoader();
            //   Scene
            this.scene = new THREE.Scene();
            this.scene.fog = new THREE.FogExp2(0x000000, 0.00000025);
            this.clock = new THREE.Clock();
            // Camera
            this.camera = new THREE.PerspectiveCamera(
                25,
                container.clientWidth / container.clientHeight,
                50,
                1e7
            );
            //Lights
            const Ambientlight = new THREE.AmbientLight(0xddeeff, 0.5); // soft white light
            this.scene.add(Ambientlight);
            let dirLight = new THREE.DirectionalLight(0xddeeff, 1);
            dirLight.position
                .set(this.radius * 50, 0, this.radius * 50)
                .normalize();
            this.scene.add(dirLight);

            // Flare
            const flare = new THREE.PointLight(0xffffff, 1.5, 1000);
            flare.position
                .set(this.radius * 50, 0, this.radius * 50)
                .normalize();
            this.scene.add(flare);

            flare.position.z = this.radius * 11;
            // flare.position.y = this.radius * -0.5;
            // flare.position.x = this.radius * 0.86;

            const textureFlare0 = textureLoader.load(lensFlare0);
            const textureFlare3 = textureLoader.load(lensFlare3);

            const lensflare = new Lensflare();

            lensflare.addElement(
                new LensflareElement(textureFlare0, 1200, 0, flare.color)
            );
            lensflare.addElement(new LensflareElement(textureFlare3, 60, 0.6));
            lensflare.addElement(new LensflareElement(textureFlare3, 70, 0.7));
            lensflare.addElement(new LensflareElement(textureFlare3, 120, 0.9));
            lensflare.addElement(new LensflareElement(textureFlare3, 70, 1));
            flare.add(lensflare);

            // Material

            // earthDayMap
            // earthNightMap
            // earthNightBlue

            const materialNormalMap = new THREE.MeshPhongMaterial({
                color: 0x666666,
                specular: 0x333333,
                shininess: 15,
                map: textureLoader.load(earthDayMap),
                normalMap: textureLoader.load(earthNormalMap),
                specularMap: textureLoader.load(earthSpecularMap),
                // y scale is negated to compensate for normal map handedness.
                normalScale: new THREE.Vector2(0.85, -0.85)
            });
            // const materialNormalMap = new THREE.MeshPhysicalMaterial({
            //   map: textureLoader.load(earthNightMap),
            //   normalMap: textureLoader.load(earthNormalMap),
            //   normalScale: new THREE.Vector2(0.85, -0.85),
            // });

            // planet

            this.geometry = new THREE.SphereGeometry(this.radius, 100, 80);

            this.meshPlanet = new THREE.Mesh(this.geometry, materialNormalMap);

            // this.meshPlanet.rotation.x = -0.5;
            this.meshPlanet.rotation.z = this.tilt;
            this.scene.add(this.meshPlanet);

            // clouds

            const materialClouds = new THREE.MeshLambertMaterial({
                color: 0xddeeff,
                alphaMap: textureLoader.load(earthClouds),
                transparent: true,
                opacity: 0.5
            });

            this.meshClouds = new THREE.Mesh(this.geometry, materialClouds);
            this.meshClouds.scale.set(
                this.cloudsScale,
                this.cloudsScale,
                this.cloudsScale
            );
            this.meshClouds.rotation.z = this.tilt;
            this.scene.add(this.meshClouds);

            // stars

            const r = this.radius,
                starsGeometry = [
                    new THREE.BufferGeometry(),
                    new THREE.BufferGeometry()
                ];

            const vertices1 = [];
            const vertices2 = [];

            const vertex = new THREE.Vector3();

            for (let i = 0; i < 250; i++) {
                vertex.x = Math.random() * 2 - 1;
                vertex.y = Math.random() * 2 - 1;
                vertex.z = Math.random() * 2 - 1;
                vertex.multiplyScalar(r);

                vertices1.push(vertex.x, vertex.y, vertex.z);
            }

            for (let i = 0; i < 1500; i++) {
                vertex.x = Math.random() * 2 - 1;
                vertex.y = Math.random() * 2 - 1;
                vertex.z = Math.random() * 2 - 1;
                vertex.multiplyScalar(r);

                vertices2.push(vertex.x, vertex.y, vertex.z);
            }

            starsGeometry[0].setAttribute(
                "position",
                new THREE.Float32BufferAttribute(vertices1, 3)
            );
            starsGeometry[1].setAttribute(
                "position",
                new THREE.Float32BufferAttribute(vertices2, 3)
            );

            const starsMaterials = [
                new THREE.PointsMaterial({
                    color: 0x555555,
                    size: 2,
                    sizeAttenuation: false
                }),
                new THREE.PointsMaterial({
                    color: 0x555555,
                    size: 1,
                    sizeAttenuation: false
                }),
                new THREE.PointsMaterial({
                    color: 0x333333,
                    size: 2,
                    sizeAttenuation: false
                }),
                new THREE.PointsMaterial({
                    color: 0x3a3a3a,
                    size: 1,
                    sizeAttenuation: false
                }),
                new THREE.PointsMaterial({
                    color: 0x1a1a1a,
                    size: 2,
                    sizeAttenuation: false
                }),
                new THREE.PointsMaterial({
                    color: 0x1a1a1a,
                    size: 1,
                    sizeAttenuation: false
                })
            ];

            for (let i = 10; i < 30; i++) {
                const stars = new THREE.Points(
                    starsGeometry[i % 2],
                    starsMaterials[i % 6]
                );

                stars.rotation.x = Math.random() * 6;
                stars.rotation.y = Math.random() * 6;
                stars.rotation.z = Math.random() * 6;
                stars.scale.setScalar(i * 10);

                stars.matrixAutoUpdate = false;
                stars.updateMatrix();

                this.scene.add(stars);
            }
            // Renderer
            this.renderer = new THREE.WebGLRenderer({ antialias: true });
            this.renderer.setPixelRatio(window.devicePixelRatio);
            this.renderer.setSize(
                container.clientWidth,
                container.clientHeight
            );
            container.appendChild(this.renderer.domElement);

            // controls
            this.controls = new OrbitControls(
                this.camera,
                this.renderer.domElement
            );
            this.controls.maxDistance = this.radius * 10;
            this.controls.minDistance = this.radius * 2.4;
            this.camera.position.set(this.radius * 2.5, 0, this.radius * 1.5);

            let ControlscenterPosition = this.controls.target.clone();
            ControlscenterPosition.y = 0;
            let ControlsgroundPosition = this.camera.position.clone();
            ControlsgroundPosition.y = 0;
            let e = ControlscenterPosition.distanceTo(ControlsgroundPosition);

            let Controlsorigin = new THREE.Vector2(this.controls.target.y, 0);
            let Controlsremote = new THREE.Vector2(-3, e); // replace 0 with raycasted ground altitude
            let ControlsangleRadians = Math.atan2(
                Controlsremote.y - Controlsorigin.y,
                Controlsremote.x - Controlsorigin.x
            );
            this.controls.maxPolarAngle = Math.PI / 2 + 0.55;
            this.controls.minPolarAngle = Math.PI / 2 - 0.55;

            this.controls.update();
        },
        animate() {
            requestAnimationFrame(this.animate);
            this.meshClouds.rotation.y += this.rotationSpeed;
            this.meshPlanet.rotation.y += this.rotationSpeed * 0.8;
            this.renderer.render(this.scene, this.camera);
        },
        onWindowResize() {
            let container = document.getElementById("container");
            if (!container || container == null) {
                return;
            }
            this.camera.aspect = container.clientWidth / container.clientHeight;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(
                container.clientWidth,
                container.clientHeight
            );
        }
    },
    mounted() {
        this.init();
        this.animate();
        window.addEventListener("resize", this.onWindowResize, false);
    }
};
</script>

<style scoped>
#container {
    min-height: 220px;
    min-width: 240px;
    height: 100%;
    width: 100%;
}
/* //TODO give your container a size. */
</style>
