<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Neon Depths - Interactive Cube Experience</title>
    <style>
    body {
        margin: 0;
        overflow: hidden;
        background-color: #000;
        font-family: 'Arial', sans-serif;
        cursor: none;
    }

    canvas {
        display: block;
    }

    .info {
        position: absolute;
        top: 10px;
        left: 10px;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 15px;
        border-radius: 10px;
        font-family: 'Arial', sans-serif;
        pointer-events: none;
        z-index: 100;
        border: 1px solid rgba(0, 255, 255, 0.3);
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }

    .info h2 {
        margin-top: 0;
        color: #0ff;
        text-shadow: 0 0 10px #0ff;
    }

    .info p {
        margin: 5px 0;
        font-size: 14px;
    }

    .controls {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 15px;
        border-radius: 10px;
        color: white;
        z-index: 100;
        border: 1px solid rgba(255, 0, 255, 0.3);
        box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
        backdrop-filter: blur(5px);
    }

    .controls button,
    .controls select {
        background-color: rgba(0, 0, 0, 0.7);
        color: #0ff;
        border: 1px solid #0ff;
        border-radius: 5px;
        padding: 5px 10px;
        margin: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .controls button:hover,
    .controls select:hover {
        background-color: rgba(0, 255, 255, 0.2);
        box-shadow: 0 0 10px #0ff;
    }

    .loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        color: #0ff;
        font-size: 24px;
        text-shadow: 0 0 10px #0ff;
    }

    .loading-bar {
        width: 300px;
        height: 20px;
        background-color: rgba(0, 255, 255, 0.1);
        border-radius: 10px;
        margin-top: 20px;
        overflow: hidden;
        position: relative;
    }

    .loading-progress {
        height: 100%;
        background: linear-gradient(90deg, #0ff, #f0f, #0ff);
        background-size: 200% 100%;
        animation: gradient-shift 2s linear infinite;
        width: 0%;
        transition: width 0.3s ease;
    }

    .custom-cursor {
        position: fixed;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid rgba(0, 255, 255, 0.7);
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
        pointer-events: none;
        transform: translate(-50%, -50%);
        z-index: 9999;
        transition: transform 0.1s ease, background-color 0.3s ease;
    }

    .custom-cursor.active {
        background-color: rgba(255, 0, 255, 0.3);
        transform: translate(-50%, -50%) scale(1.5);
        border-color: rgba(255, 0, 255, 0.7);
    }

    .custom-cursor .trail {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: rgba(0, 255, 255, 0.2);
        transform: scale(1);
        opacity: 0.7;
    }

    @keyframes gradient-shift {
        0% {
            background-position: 0% 0%;
        }

        100% {
            background-position: 200% 0%;
        }
    }

    .volume-control {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .volume-control input {
        margin-left: 10px;
        width: 100px;
    }

    .theme-toggle {
        margin-top: 10px;
    }

    .power-meter {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        border-radius: 10px;
        color: white;
        z-index: 100;
        border: 1px solid rgba(0, 255, 255, 0.3);
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
        backdrop-filter: blur(5px);
        display: none;
    }

    .power-bar {
        width: 150px;
        height: 15px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 7px;
        overflow: hidden;
        margin-top: 5px;
    }

    .power-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #0ff, #f0f);
        transition: width 0.1s ease;
    }
    </style>
</head>

<body>
    <div class="loading">
        <div>LOADING COSMIC NEON DEPTHS</div>
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
    </div>

    <div class="custom-cursor"></div>

    <div class="info">
        <h2>Cosmic Neon Depths</h2>
        <p>🔄 Drag to rotate view</p>
        <p>🔍 Scroll to zoom in/out</p>
        <p>👆 Click + drag to push cubes</p>
        <p>🎮 Press SPACE to create shockwave</p>
        <p>🎵 Press M to toggle music</p>
        <p>💥 Hold SPACE to charge shockwave</p>
    </div>

    <div class="controls">
        <button id="theme-toggle">Change Theme</button>
        <button id="add-cube">Add Cube</button>
        <button id="reset">Reset Scene</button>
        <div class="volume-control">
            <span>Volume:</span>
            <input type="range" id="volume" min="0" max="1" step="0.1" value="0.5">
        </div>
        <div class="theme-toggle">
            <select id="particle-style">
                <option value="bubbles">Underwater Bubbles</option>
                <option value="stars">Space Stars</option>
                <option value="neon">Neon Particles</option>
                <option value="mixed" selected>Mixed Theme</option>
            </select>
        </div>
    </div>

    <div class="power-meter">
        <div>Shockwave Power</div>
        <div class="power-bar">
            <div class="power-fill"></div>
        </div>
    </div>

    <!-- Load Three.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <script>
    // ===== INITIALIZATION =====
    // Simulate loading progress
    const loadingProgress = document.querySelector('.loading-progress');
    const loadingScreen = document.querySelector('.loading');
    let progress = 0;
    const loadingInterval = setInterval(() => {
        progress += Math.random() * 5;
        if (progress >= 100) {
            progress = 100;
            clearInterval(loadingInterval);
            setTimeout(() => {
                loadingScreen.style.opacity = 0;
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 500);
            }, 500);
        }
        loadingProgress.style.width = `${progress}%`;
    }, 100);

    // Custom cursor
    const cursor = document.querySelector('.custom-cursor');
    let cursorTrails = [];
    const maxTrails = 5;

    document.addEventListener('mousemove', (e) => {
        cursor.style.left = `${e.clientX}px`;
        cursor.style.top = `${e.clientY}px`;

        // Create trail effect
        if (cursorTrails.length < maxTrails) {
            const trail = document.createElement('div');
            trail.className = 'trail';
            cursor.appendChild(trail);
            cursorTrails.push({
                element: trail,
                x: e.clientX,
                y: e.clientY,
                life: 1
            });
        }
    });

    document.addEventListener('mousedown', () => {
        cursor.classList.add('active');
    });

    document.addEventListener('mouseup', () => {
        cursor.classList.remove('active');
    });

    // Update cursor trails
    function updateCursorTrails() {
        for (let i = cursorTrails.length - 1; i >= 0; i--) {
            const trail = cursorTrails[i];
            trail.life -= 0.05;

            if (trail.life <= 0) {
                trail.element.remove();
                cursorTrails.splice(i, 1);
            } else {
                trail.element.style.transform = `scale(${1 + (1 - trail.life) * 2})`;
                trail.element.style.opacity = trail.life;
            }
        }
        requestAnimationFrame(updateCursorTrails);
    }
    updateCursorTrails();

    // ===== AUDIO SYSTEM =====
    // Enhanced audio context for Growtopia-style sound effects
    let audioContext;
    let audioEnabled = false;
    let volumeLevel = 0.5;

    // Initialize audio context on user interaction
    document.addEventListener('click', initAudio, {
        once: true
    });

    function initAudio() {
        try {
            audioContext = new(window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            console.warn('Web Audio API not supported in this browser');
        }
    }

    // Sound generation functions with Growtopia-style effects
    function playCollisionSound() {
        if (!audioContext || !audioEnabled) return;

        // Create oscillator for main tone
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        // Create filter for more "plucky" sound
        const filter = audioContext.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.value = 1000;
        filter.Q.value = 8;

        // Random pitch for variety
        const pitch = 300 + Math.random() * 200;
        oscillator.type = 'triangle'; // More "plucky" waveform
        oscillator.frequency.setValueAtTime(pitch, audioContext.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(pitch * 0.5, audioContext.currentTime + 0.2);

        // Quick attack, medium decay envelope
        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(volumeLevel * 0.4, audioContext.currentTime + 0.01);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.3);

        // Connect nodes
        oscillator.connect(filter);
        filter.connect(gainNode);
        gainNode.connect(audioContext.destination);

        // Add a bit of noise for "clicky" attack
        const noiseLength = 0.05;
        const bufferSize = audioContext.sampleRate * noiseLength;
        const noiseBuffer = audioContext.createBuffer(1, bufferSize, audioContext.sampleRate);
        const data = noiseBuffer.getChannelData(0);

        for (let i = 0; i < bufferSize; i++) {
            data[i] = Math.random() * 2 - 1;
        }

        const noise = audioContext.createBufferSource();
        noise.buffer = noiseBuffer;

        const noiseGain = audioContext.createGain();
        noiseGain.gain.setValueAtTime(volumeLevel * 0.2, audioContext.currentTime);
        noiseGain.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.05);

        noise.connect(noiseGain);
        noiseGain.connect(audioContext.destination);

        // Start sounds
        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.3);
        noise.start();
        noise.stop(audioContext.currentTime + noiseLength);
    }

    function playShockwaveSound(power = 1.0) {
        if (!audioContext || !audioEnabled) return;

        // Base oscillator for the "whoosh" effect
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        // Filter for shaping the sound
        const filter = audioContext.createBiquadFilter();
        filter.type = 'bandpass';
        filter.frequency.value = 800;
        filter.Q.value = 2;

        // Modulate frequency for "whoosh" effect
        oscillator.type = 'sawtooth';
        oscillator.frequency.setValueAtTime(100, audioContext.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(500 * power, audioContext.currentTime + 0.5 * power);

        // Volume envelope
        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(volumeLevel * 0.5 * power, audioContext.currentTime + 0.1);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.5 * power);

        // Connect nodes
        oscillator.connect(filter);
        filter.connect(gainNode);
        gainNode.connect(audioContext.destination);

        // Add a sub-bass impact
        const subOsc = audioContext.createOscillator();
        const subGain = audioContext.createGain();

        subOsc.type = 'sine';
        subOsc.frequency.value = 60;

        subGain.gain.setValueAtTime(0, audioContext.currentTime);
        subGain.gain.linearRampToValueAtTime(volumeLevel * 0.6 * power, audioContext.currentTime + 0.05);
        subGain.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.3 * power);

        subOsc.connect(subGain);
        subGain.connect(audioContext.destination);

        // Add noise burst for texture
        const noiseLength = 0.3 * power;
        const bufferSize = audioContext.sampleRate * noiseLength;
        const noiseBuffer = audioContext.createBuffer(1, bufferSize, audioContext.sampleRate);
        const data = noiseBuffer.getChannelData(0);

        for (let i = 0; i < bufferSize; i++) {
            data[i] = Math.random() * 2 - 1;
        }

        const noise = audioContext.createBufferSource();
        noise.buffer = noiseBuffer;

        const noiseFilter = audioContext.createBiquadFilter();
        noiseFilter.type = 'highpass';
        noiseFilter.frequency.value = 2000;

        const noiseGain = audioContext.createGain();
        noiseGain.gain.setValueAtTime(volumeLevel * 0.2 * power, audioContext.currentTime);
        noiseGain.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.2 * power);

        noise.connect(noiseFilter);
        noiseFilter.connect(noiseGain);
        noiseGain.connect(audioContext.destination);

        // Start all sound components
        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.5 * power);

        subOsc.start();
        subOsc.stop(audioContext.currentTime + 0.3 * power);

        noise.start();
        noise.stop(audioContext.currentTime + noiseLength);
    }

    function playBounceSound() {
        if (!audioContext || !audioEnabled) return;

        // Main tone oscillator
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        // Growtopia-style "boing" sound
        oscillator.type = 'triangle';
        const pitch = 400 + Math.random() * 100;
        oscillator.frequency.setValueAtTime(pitch, audioContext.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(pitch * 0.7, audioContext.currentTime + 0.15);

        // Quick attack, fast decay
        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(volumeLevel * 0.3, audioContext.currentTime + 0.01);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.15);

        // Add a bit of distortion for character
        const distortion = audioContext.createWaveShaper();

        function makeDistortionCurve(amount) {
            const k = amount;
            const n_samples = 44100;
            const curve = new Float32Array(n_samples);
            const deg = Math.PI / 180;

            for (let i = 0; i < n_samples; ++i) {
                const x = i * 2 / n_samples - 1;
                curve[i] = (3 + k) * x * 20 * deg / (Math.PI + k * Math.abs(x));
            }
            return curve;
        }

        distortion.curve = makeDistortionCurve(5);
        distortion.oversample = '4x';

        // Connect nodes with distortion
        oscillator.connect(distortion);
        distortion.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.15);
    }

    function playCubeGrabSound() {
        if (!audioContext || !audioEnabled) return;

        // Create oscillator for "pick up" sound
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        // Growtopia-style pickup sound
        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(300, audioContext.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(600, audioContext.currentTime + 0.1);

        // Quick ramp up
        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(volumeLevel * 0.3, audioContext.currentTime + 0.05);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.2);

        // Connect nodes
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.2);
    }

    function playCubeDropSound() {
        if (!audioContext || !audioEnabled) return;

        // Create oscillator for "drop" sound
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        // Growtopia-style drop sound
        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(600, audioContext.currentTime);
        oscillator.frequency.exponentialRampToValueAtTime(300, audioContext.currentTime + 0.15);

        // Quick attack, medium decay
        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(volumeLevel * 0.3, audioContext.currentTime + 0.01);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.15);

        // Connect nodes
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.15);
    }

    // Background music using oscillators - Growtopia-inspired theme
    let musicPlaying = false;
    let musicNodes = [];

    function toggleBackgroundMusic() {
        if (!audioContext) return;

        audioEnabled = !audioEnabled;

        if (audioEnabled) {
            startBackgroundMusic();
        } else {
            stopBackgroundMusic();
        }
    }

    function startBackgroundMusic() {
        if (!audioContext || musicPlaying) return;

        musicPlaying = true;

        // Create Growtopia-style chiptune background music
        // Base frequencies for a happy, upbeat chord progression
        const progressions = [
            [220, 277.18, 329.63, 440], // A minor
            [246.94, 311.13, 370, 493.88], // B diminished
            [261.63, 329.63, 392, 523.25], // C major
            [293.66, 369.99, 440, 587.33] // D major
        ];

        // Progression timing
        const progressionDuration = 2; // seconds per chord
        let currentProgression = 0;

        // Create oscillators for the current chord
        function createChord(frequencies) {
            const nodes = [];

            frequencies.forEach((freq, i) => {
                // Main oscillator
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();

                // Use different waveforms for variety
                oscillator.type = i % 2 === 0 ? 'square' : 'triangle';
                oscillator.frequency.value = freq;

                // Add slight detuning for richness
                if (i > 0) {
                    oscillator.detune.value = Math.random() * 10 - 5;
                }

                // Volume based on note position
                const baseVolume = i === 0 ? 0.08 : 0.05;
                gainNode.gain.value = volumeLevel * baseVolume;

                // Add filter for tone shaping
                const filter = audioContext.createBiquadFilter();
                filter.type = 'lowpass';
                filter.frequency.value = 2000;
                filter.Q.value = 1;

                // Connect nodes
                oscillator.connect(filter);
                filter.connect(gainNode);
                gainNode.connect(audioContext.destination);

                oscillator.start();

                nodes.push({
                    oscillator,
                    gainNode,
                    filter
                });
            });

            return nodes;
        }

        // Initial chord
        musicNodes = createChord(progressions[currentProgression]);

        // Set up chord progression interval
        const progressionInterval = setInterval(() => {
            if (!audioEnabled || !musicPlaying) {
                clearInterval(progressionInterval);
                return;
            }

            // Fade out current chord
            musicNodes.forEach(node => {
                node.gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.5);
                setTimeout(() => {
                    node.oscillator.stop();
                }, 500);
            });

            // Move to next chord
            currentProgression = (currentProgression + 1) % progressions.length;
            musicNodes = createChord(progressions[currentProgression]);

        }, progressionDuration * 1000);

        // Add a simple arpeggiator for melody
        const arpNotes = [0, 4, 7, 12, 7, 4];
        let arpIndex = 0;

        const arpeggiator = setInterval(() => {
            if (!audioEnabled || !musicPlaying) {
                clearInterval(arpeggiator);
                return;
            }

            const baseFreq = progressions[currentProgression][0];
            const note = arpNotes[arpIndex];
            arpIndex = (arpIndex + 1) % arpNotes.length;

            // Calculate frequency using equal temperament
            const freq = baseFreq * Math.pow(2, note / 12);

            // Create arpeggio note
            const osc = audioContext.createOscillator();
            const gain = audioContext.createGain();

            osc.type = 'square';
            osc.frequency.value = freq;

            // Quick attack and decay
            gain.gain.setValueAtTime(0, audioContext.currentTime);
            gain.gain.linearRampToValueAtTime(volumeLevel * 0.04, audioContext.currentTime + 0.01);
            gain.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.2);

            osc.connect(gain);
            gain.connect(audioContext.destination);

            osc.start();
            osc.stop(audioContext.currentTime + 0.2);

        }, 200); // 16th notes at 120bpm
    }

    function stopBackgroundMusic() {
        if (!musicPlaying) return;

        musicPlaying = false;

        musicNodes.forEach(node => {
            node.gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.5);
            setTimeout(() => {
                node.oscillator.stop();
            }, 500);
        });

        musicNodes = [];
    }

    document.addEventListener('keydown', (e) => {
        if (e.key.toLowerCase() === 'm') {
            toggleBackgroundMusic();
        }
    });

    document.getElementById('volume').addEventListener('input', (e) => {
        volumeLevel = parseFloat(e.target.value);

        // Update current music volume if playing
        if (musicPlaying) {
            musicNodes.forEach(node => {
                node.gainNode.gain.value = volumeLevel * 0.05;
            });
        }
    });

    // ===== THREE.JS SETUP =====
    // Initialize scene, camera, and renderer
    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(
        75,
        window.innerWidth / window.innerHeight,
        0.1,
        1000
    );
    camera.position.z = 50;

    const renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    document.body.appendChild(renderer.domElement);

    // Add OrbitControls
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.rotateSpeed = 0.8;
    controls.zoomSpeed = 1.2;
    controls.panSpeed = 0.8;
    controls.minDistance = 20;
    controls.maxDistance = 100;

    // ===== ENVIRONMENT SETUP =====
    // Create space background with stars
    function createSpaceBackground() {
        // Create a large sphere for the space background
        const spaceGeometry = new THREE.SphereGeometry(400, 64, 64);
        // Invert the geometry so we can see it from inside
        spaceGeometry.scale(-1, 1, 1);

        const spaceMaterial = new THREE.MeshBasicMaterial({
            color: 0x000011,
            side: THREE.BackSide
        });

        const spaceSphere = new THREE.Mesh(spaceGeometry, spaceMaterial);
        scene.add(spaceSphere);

        return spaceSphere;
    }

    const spaceBackground = createSpaceBackground();

    // Create underwater effect with bubbles
    function createUnderwaterEffect() {
        const bubbleGroup = new THREE.Group();
        scene.add(bubbleGroup);

        // Create bubbles
        const bubbleCount = 100;
        const bubbles = [];

        for (let i = 0; i < bubbleCount; i++) {
            const size = Math.random() * 0.5 + 0.1;
            const bubbleGeometry = new THREE.SphereGeometry(size, 16, 16);
            const bubbleMaterial = new THREE.MeshPhongMaterial({
                color: 0x88ccff,
                transparent: true,
                opacity: 0.3,
                shininess: 100,
                specular: 0x00ffff
            });

            const bubble = new THREE.Mesh(bubbleGeometry, bubbleMaterial);

            // Random position within bounds
            bubble.position.set(
                THREE.MathUtils.randFloatSpread(80),
                THREE.MathUtils.randFloatSpread(80),
                THREE.MathUtils.randFloatSpread(80)
            );

            // Store bubble speed
            bubble.userData.speed = Math.random() * 0.05 + 0.02;

            bubbleGroup.add(bubble);
            bubbles.push(bubble);
        }

        return {
            bubbleGroup,
            bubbles
        };
    }

    const {
        bubbleGroup,
        bubbles
    } = createUnderwaterEffect();

    // Create particle systems
    function createParticleSystems() {
        const particleGroup = new THREE.Group();
        scene.add(particleGroup);

        // Space stars
        const starsGeometry = new THREE.BufferGeometry();
        const starCount = 1000;
        const starPositions = new Float32Array(starCount * 3);
        const starSizes = new Float32Array(starCount);

        for (let i = 0; i < starCount; i++) {
            const i3 = i * 3;
            starPositions[i3] = THREE.MathUtils.randFloatSpread(200);
            starPositions[i3 + 1] = THREE.MathUtils.randFloatSpread(200);
            starPositions[i3 + 2] = THREE.MathUtils.randFloatSpread(200);

            starSizes[i] = Math.random() * 2 + 0.5;
        }

        starsGeometry.setAttribute('position', new THREE.BufferAttribute(starPositions, 3));
        starsGeometry.setAttribute('size', new THREE.BufferAttribute(starSizes, 1));

        const starMaterial = new THREE.PointsMaterial({
            color: 0xffffff,
            size: 1,
            transparent: true,
            opacity: 0.8,
            sizeAttenuation: true
        });

        const stars = new THREE.Points(starsGeometry, starMaterial);
        particleGroup.add(stars);

        // Neon particles
        const neonGeometry = new THREE.BufferGeometry();
        const neonCount = 300;
        const neonPositions = new Float32Array(neonCount * 3);
        const neonColors = new Float32Array(neonCount * 3);
        const neonSizes = new Float32Array(neonCount);

        const neonColorOptions = [
            new THREE.Color(0xff00ff), // Magenta
            new THREE.Color(0x00ffff), // Cyan
            new THREE.Color(0xff00aa), // Pink
            new THREE.Color(0x00ffaa) // Teal
        ];

        for (let i = 0; i < neonCount; i++) {
            const i3 = i * 3;
            neonPositions[i3] = THREE.MathUtils.randFloatSpread(100);
            neonPositions[i3 + 1] = THREE.MathUtils.randFloatSpread(100);
            neonPositions[i3 + 2] = THREE.MathUtils.randFloatSpread(100);

            const color = neonColorOptions[Math.floor(Math.random() * neonColorOptions.length)];
            neonColors[i3] = color.r;
            neonColors[i3 + 1] = color.g;
            neonColors[i3 + 2] = color.b;

            neonSizes[i] = Math.random() * 3 + 1;
        }

        neonGeometry.setAttribute('position', new THREE.BufferAttribute(neonPositions, 3));
        neonGeometry.setAttribute('color', new THREE.BufferAttribute(neonColors, 3));
        neonGeometry.setAttribute('size', new THREE.BufferAttribute(neonSizes, 1));

        const neonMaterial = new THREE.PointsMaterial({
            size: 1,
            vertexColors: true,
            transparent: true,
            opacity: 0.8,
            sizeAttenuation: true
        });

        const neonParticles = new THREE.Points(neonGeometry, neonMaterial);
        particleGroup.add(neonParticles);

        return {
            particleGroup,
            stars,
            neonParticles
        };
    }

    const {
        particleGroup,
        stars,
        neonParticles
    } = createParticleSystems();

    // Lighting
    const ambientLight = new THREE.AmbientLight(0x333333, 0.5);
    scene.add(ambientLight);

    const pointLight = new THREE.PointLight(0x00ffff, 1, 100);
    pointLight.position.set(10, 10, 10);
    pointLight.castShadow = true;
    scene.add(pointLight);

    const pointLight2 = new THREE.PointLight(0xff00ff, 1, 100);
    pointLight2.position.set(-10, -10, 10);
    pointLight2.castShadow = true;
    scene.add(pointLight2);

    // Add a spotlight for dramatic effect
    const spotlight = new THREE.SpotLight(0xffffff, 1);
    spotlight.position.set(0, 30, 0);
    spotlight.angle = Math.PI / 6;
    spotlight.penumbra = 0.2;
    spotlight.decay = 2;
    spotlight.distance = 100;
    spotlight.castShadow = true;
    spotlight.shadow.mapSize.width = 1024;
    spotlight.shadow.mapSize.height = 1024;
    scene.add(spotlight);

    // ===== CUBE CREATION =====
    // Define colors for Rubik's cube faces with neon glow
    const colors = [
        0xff0055, // Neon Red
        0x00ff66, // Neon Green
        0x0066ff, // Neon Blue
        0xffff00, // Neon Yellow
        0xff6600, // Neon Orange
        0xffffff, // White
    ];

    // Create materials with proper lighting and glow
    const faceMaterials = colors.map(
        (color) =>
        new THREE.MeshStandardMaterial({
            color: color,
            roughness: 0.3,
            metalness: 0.7,
            emissive: new THREE.Color(color).multiplyScalar(0.2),
            emissiveIntensity: 0.5
        })
    );

    // Function to create a Rubik's cube with improved visuals
    function createRubikCube() {
        const group = new THREE.Group();
        const pieceSize = 1;
        const gap = 0.1; // Increased gap for better visual separation
        const totalPieceSize = pieceSize + gap;

        for (let x = -1; x <= 1; x++) {
            for (let y = -1; y <= 1; y++) {
                for (let z = -1; z <= 1; z++) {
                    if (x === 0 && y === 0 && z === 0) continue; // Skip center piece

                    const geometry = new THREE.BoxGeometry(
                        pieceSize,
                        pieceSize,
                        pieceSize
                    );

                    // Assign materials to faces with better pattern
                    const materials = [];
                    for (let i = 0; i < 6; i++) {
                        // Create a pattern based on position
                        let colorIndex;
                        if (i === 0) colorIndex = x === 1 ? 0 : 5; // Right/left faces
                        else if (i === 1) colorIndex = x === -1 ? 1 : 4; // Right/left faces
                        else if (i === 2) colorIndex = y === 1 ? 2 : 3; // Top/bottom faces
                        else if (i === 3) colorIndex = y === -1 ? 0 : 5; // Top/bottom faces
                        else if (i === 4) colorIndex = z === 1 ? 1 : 4; // Front/back faces
                        else colorIndex = z === -1 ? 2 : 3; // Front/back faces

                        materials.push(faceMaterials[colorIndex]);
                    }

                    const cube = new THREE.Mesh(geometry, materials);
                    cube.castShadow = true;
                    cube.receiveShadow = true;

                    cube.position.set(
                        x * totalPieceSize,
                        y * totalPieceSize,
                        z * totalPieceSize
                    );

                    // Add subtle rotation animation
                    cube.userData.rotationSpeed = {
                        x: THREE.MathUtils.randFloatSpread(0.005),
                        y: THREE.MathUtils.randFloatSpread(0.005),
                        z: THREE.MathUtils.randFloatSpread(0.005)
                    };

                    group.add(cube);
                }
            }
        }

        // Calculate bounding radius for collision detection
        group.userData.boundingRadius = Math.sqrt(3) * (1.5 * totalPieceSize);

        // Add glow effect
        const glowMaterial = new THREE.MeshBasicMaterial({
            color: 0x00ffff,
            transparent: true,
            opacity: 0.1,
            side: THREE.BackSide
        });

        const glowGeometry = new THREE.SphereGeometry(group.userData.boundingRadius * 1.2, 32, 32);
        const glowMesh = new THREE.Mesh(glowGeometry, glowMaterial);
        group.add(glowMesh);

        // Add mass property for physics
        group.userData.mass = 1.0;

        return group;
    }

    // Helper function for random vectors
    function randomVec3(min, max) {
        return new THREE.Vector3(
            THREE.MathUtils.randFloat(min, max),
            THREE.MathUtils.randFloat(min, max),
            THREE.MathUtils.randFloat(min, max)
        );
    }

    // Arrays to store cubes and their properties
    const cubeGroups = [];
    const velocities = [];
    const angularVelocities = [];
    const trails = [];

    // Create cubes with initial positions and velocities
    const initialCubeCount = 15; // Reduced initial count for better performance
    const initialSpeedMin = 0.05;
    const initialSpeedMax = 0.2;

    function createInitialCubes() {
        for (let i = 0; i < initialCubeCount; i++) {
            createCube();
        }
    }

    function createCube() {
        const rubik = createRubikCube();

        // Set initial position
        rubik.position.copy(randomVec3(-15, 15));

        // Ensure cubes don't overlap initially
        let overlapping = true;
        let attempts = 0;
        const maxAttempts = 10;

        while (overlapping && attempts < maxAttempts) {
            attempts++;
            overlapping = false;
            rubik.position.copy(randomVec3(-15, 15));

            for (let j = 0; j < cubeGroups.length; ++j) {
                if (
                    rubik.position.distanceTo(cubeGroups[j].position) <
                    rubik.userData.boundingRadius + cubeGroups[j].userData.boundingRadius
                ) {
                    overlapping = true;
                    break;
                }
            }
        }

        scene.add(rubik);
        cubeGroups.push(rubik);

        // Set initial velocity
        velocities.push(
            randomVec3(initialSpeedMin, initialSpeedMax).multiplyScalar(
                Math.random() < 0.5 ? 1 : -1
            )
        );

        // Set initial rotation
        angularVelocities.push(randomVec3(-0.01, 0.01));

        // Create trail for this cube
        const trailGeometry = new THREE.BufferGeometry();
        const trailMaterial = new THREE.LineBasicMaterial({
            color: new THREE.Color().setHSL(Math.random(), 1, 0.5),
            transparent: true,
            opacity: 0.4
        });

        const trailPoints = [];
        for (let i = 0; i < 20; i++) {
            trailPoints.push(rubik.position.clone());
        }

        trailGeometry.setFromPoints(trailPoints);
        const trail = new THREE.Line(trailGeometry, trailMaterial);
        scene.add(trail);

        trails.push({
            line: trail,
            points: trailPoints,
            updateCounter: 0
        });

        return rubik;
    }

    // Create initial cubes
    createInitialCubes();

    // ===== ENHANCED INTERACTIVE FEATURES =====
    // Mouse interaction with improved physics
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();
    const mouseSpeed = new THREE.Vector2();
    const lastMousePosition = new THREE.Vector2();
    let isMouseDown = false;
    let selectedCube = null;
    let isDragging = false;
    let dragStartPosition = new THREE.Vector3();
    let dragOffset = new THREE.Vector3();

    // For p5.js style interaction
    let mouseWorldPosition = new THREE.Vector3();

    // Update mouse world position
    function updateMouseWorldPosition() {
        // Create a ray from the camera through the mouse position
        raycaster.setFromCamera(mouse, camera);

        // Calculate the point at a fixed distance from camera
        // This gives us a consistent interaction plane
        const distance = 30; // Distance from camera
        mouseWorldPosition.copy(camera.position).add(
            raycaster.ray.direction.clone().multiplyScalar(distance)
        );
    }

    document.addEventListener('mousemove', (event) => {
        // Update mouse position for raycasting
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        // Calculate mouse speed
        mouseSpeed.x = event.clientX - lastMousePosition.x;
        mouseSpeed.y = event.clientY - lastMousePosition.y;

        lastMousePosition.x = event.clientX;
        lastMousePosition.y = event.clientY;

        // Update mouse world position
        updateMouseWorldPosition();

        // Handle dragging
        if (isDragging && selectedCube !== null) {
            // Calculate new position based on mouse movement
            const newPosition = new THREE.Vector3();
            newPosition.copy(mouseWorldPosition).sub(dragOffset);

            // Apply position directly for direct manipulation
            cubeGroups[selectedCube].position.copy(newPosition);

            // Calculate velocity based on movement
            const moveVector = new THREE.Vector3().subVectors(
                cubeGroups[selectedCube].position,
                dragStartPosition
            );

            // Update velocity based on movement
            velocities[selectedCube].copy(moveVector.multiplyScalar(0.1));

            // Update drag start position for next frame
            dragStartPosition.copy(cubeGroups[selectedCube].position);
        }
    });

    document.addEventListener('mousedown', () => {
        isMouseDown = true;

        // Check for cube selection
        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(cubeGroups, true);

        if (intersects.length > 0) {
            // Find the parent cube group
            let parent = intersects[0].object;
            while (parent.parent !== scene) {
                parent = parent.parent;
            }

            // Find the index of the selected cube
            const cubeIndex = cubeGroups.indexOf(parent);
            if (cubeIndex !== -1) {
                selectedCube = cubeIndex;
                isDragging = true;

                // Store initial positions for dragging
                dragStartPosition.copy(cubeGroups[selectedCube].position);
                dragOffset.copy(mouseWorldPosition).sub(dragStartPosition);

                // Stop current motion
                velocities[selectedCube].set(0, 0, 0);
                angularVelocities[selectedCube].multiplyScalar(0.5);

                // Play grab sound
                playCubeGrabSound();

                // Highlight the selected cube
                const glowMesh = cubeGroups[selectedCube].children.find(
                    child => child.material && child.material.side === THREE.BackSide
                );

                if (glowMesh) {
                    glowMesh.material.color.set(0xff00ff);
                    glowMesh.material.opacity = 0.2;
                }
            }
        }
    });

    document.addEventListener('mouseup', () => {
        isMouseDown = false;

        if (isDragging && selectedCube !== null) {
            // Apply final velocity based on mouse speed
            const speedFactor = 0.02;
            velocities[selectedCube].x += mouseSpeed.x * speedFactor;
            velocities[selectedCube].y -= mouseSpeed.y * speedFactor; // Invert Y for correct direction

            // Play drop sound
            playCubeDropSound();

            // Reset glow effect
            const glowMesh = cubeGroups[selectedCube].children.find(
                child => child.material && child.material.side === THREE.BackSide
            );

            if (glowMesh) {
                glowMesh.material.color.set(0x00ffff);
                glowMesh.material.opacity = 0.1;
            }
        }

        isDragging = false;
        selectedCube = null;
    });

    // Improved shockwave with power meter
    const powerMeter = document.querySelector('.power-meter');
    const powerFill = document.querySelector('.power-fill');
    let isChargingShockwave = false;
    let shockwavePower = 0;
    const maxShockwavePower = 1.0;
    const shockwaveChargeRate = 0.02;

    // Keyboard interaction for shockwave
    document.addEventListener('keydown', (event) => {
        if (event.code === 'Space' && !isChargingShockwave && !event.repeat) {
            isChargingShockwave = true;
            shockwavePower = 0;
            powerMeter.style.display = 'block';
            powerFill.style.width = '0%';
        }
    });

    document.addEventListener('keyup', (event) => {
        if (event.code === 'Space' && isChargingShockwave) {
            isChargingShockwave = false;
            powerMeter.style.display = 'none';

            // Create shockwave with current power
            createShockwave(shockwavePower);
            shockwavePower = 0;
        }
    });

    function updateShockwavePower() {
        if (isChargingShockwave) {
            shockwavePower += shockwaveChargeRate;
            if (shockwavePower > maxShockwavePower) {
                shockwavePower = maxShockwavePower;
            }

            // Update power meter
            powerFill.style.width = `${(shockwavePower / maxShockwavePower) * 100}%`;
        }
    }

    function createShockwave(power = 0.5) {
        // Ensure minimum power
        power = Math.max(0.2, power);

        // Create visual shockwave
        const shockwaveGeometry = new THREE.RingGeometry(0.1, 0.5, 32);
        const shockwaveMaterial = new THREE.MeshBasicMaterial({
            color: power > 0.7 ? 0xff00ff : 0x00ffff,
            transparent: true,
            opacity: 0.7,
            side: THREE.DoubleSide
        });

        const shockwave = new THREE.Mesh(shockwaveGeometry, shockwaveMaterial);

        // Position shockwave in front of camera
        const direction = new THREE.Vector3();
        camera.getWorldDirection(direction);

        shockwave.position.copy(camera.position).add(direction.multiplyScalar(10));
        shockwave.lookAt(camera.position);
        scene.add(shockwave);

        // Play sound with power
        playShockwaveSound(power);

        // Animate shockwave
        const startTime = Date.now();
        const duration = 1000 * power; // ms
        const maxSize = 30 * power;
        const maxForce = 0.5 * power;

        function animateShockwave() {
            const elapsed = Date.now() - startTime;
            const progress = elapsed / duration;

            if (progress < 1) {
                const size = maxSize * progress;
                shockwave.scale.set(size, size, size);
                shockwave.material.opacity = 0.7 * (1 - progress);

                // Apply force to nearby cubes - improved p5.js style physics
                for (let i = 0; i < cubeGroups.length; i++) {
                    const cube = cubeGroups[i];
                    const distance = cube.position.distanceTo(shockwave.position);

                    if (distance < size) {
                        // Calculate force based on distance (stronger closer to shockwave)
                        const forceMagnitude = maxForce * (1 - distance / size);

                        // Direction from shockwave to cube (for pushing outward)
                        const direction = new THREE.Vector3().subVectors(
                            cube.position,
                            shockwave.position
                        ).normalize();

                        // Apply force as acceleration
                        const force = direction.multiplyScalar(forceMagnitude);
                        velocities[i].add(force);

                        // Add some random spin based on force
                        const spin = new THREE.Vector3(
                            (Math.random() - 0.5) * forceMagnitude * 0.05,
                            (Math.random() - 0.5) * forceMagnitude * 0.05,
                            (Math.random() - 0.5) * forceMagnitude * 0.05
                        );
                        angularVelocities[i].add(spin);

                        // Create impact particles at cube position
                        if (Math.random() < 0.3) {
                            createImpactParticles(cube.position.clone(), 'shockwave');
                        }
                    }
                }

                requestAnimationFrame(animateShockwave);
            } else {
                scene.remove(shockwave);
            }
        }

        animateShockwave();
    }

    // ===== PHYSICS PARAMETERS =====
    const bounds = 25;
    const maxSpeed = 0.4;
    const minSpeed = 0.05;
    const collisionDamping = 0.98;
    const wallDamping = 0.95;
    const gravity = new THREE.Vector3(0, -0.001, 0); // Very slight gravity

    // ===== ANIMATION LOOP =====
    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);
        const delta = clock.getDelta();

        // Update orbit controls
        controls.update();

        // Update shockwave power
        updateShockwavePower();

        // Rotate lights for dynamic lighting
        const time = Date.now() * 0.001;
        pointLight.position.x = Math.sin(time * 0.7) * 15;
        pointLight.position.z = Math.cos(time * 0.7) * 15;

        pointLight2.position.x = Math.sin(time * 0.5 + Math.PI) * 15;
        pointLight2.position.z = Math.cos(time * 0.5 + Math.PI) * 15;

        // Update bubbles
        bubbles.forEach(bubble => {
            bubble.position.y += bubble.userData.speed;

            // Reset bubble position when it goes out of bounds
            if (bubble.position.y > bounds) {
                bubble.position.y = -bounds;
                bubble.position.x = THREE.MathUtils.randFloatSpread(bounds * 2);
                bubble.position.z = THREE.MathUtils.randFloatSpread(bounds * 2);
            }

            // Add some wobble
            bubble.position.x += Math.sin(time * 2 + bubble.position.y) * 0.01;
            bubble.position.z += Math.cos(time * 2 + bubble.position.y) * 0.01;
        });

        // Update stars twinkle effect
        if (stars.material.size) {
            stars.material.size = 1 + Math.sin(time * 3) * 0.2;
        }

        // Update cube positions and handle collisions
        for (let i = 0; i < cubeGroups.length; i++) {
            const cube = cubeGroups[i];
            const vel = velocities[i];
            const angVel = angularVelocities[i];
            const radius = cube.userData.boundingRadius;

            // Skip physics update if being dragged
            if (isDragging && selectedCube === i) {
                continue;
            }

            // Apply gravity
            vel.add(gravity);

            // Apply movement
            cube.position.add(vel);

            // Apply rotation to cube pieces
            cube.children.forEach(piece => {
                if (piece.isMesh) {
                    piece.rotation.x += angVel.x + (piece.userData.rotationSpeed?.x || 0);
                    piece.rotation.y += angVel.y + (piece.userData.rotationSpeed?.y || 0);
                    piece.rotation.z += angVel.z + (piece.userData.rotationSpeed?.z || 0);
                }
            });

            // Update cube group rotation
            cube.rotation.x += angVel.x * 0.5;
            cube.rotation.y += angVel.y * 0.5;
            cube.rotation.z += angVel.z * 0.5;

            // Speed limits
            const speed = vel.length();
            if (speed > maxSpeed) {
                vel.normalize().multiplyScalar(maxSpeed);
            } else if (speed < minSpeed) {
                if (speed < 0.001) {
                    vel.copy(
                        randomVec3(minSpeed, minSpeed * 1.5).multiplyScalar(
                            Math.random() < 0.5 ? 1 : -1
                        )
                    );
                } else {
                    vel.normalize().multiplyScalar(minSpeed);
                }
            }

            // Bounce off walls with improved effects
            for (const axis of ["x", "y", "z"]) {
                if (Math.abs(cube.position[axis]) + radius > bounds) {
                    // Wall collision
                    if (cube.position[axis] > bounds - radius) {
                        cube.position[axis] = bounds - radius - 0.01;
                    } else if (cube.position[axis] < -bounds + radius) {
                        cube.position[axis] = -bounds + radius + 0.01;
                    }

                    // Bounce with damping
                    vel[axis] *= -1 * wallDamping;

                    // Reduce angular velocity
                    angVel.multiplyScalar(0.98);

                    // Play bounce sound with varying pitch
                    if (Math.random() < 0.3) {
                        playBounceSound();
                    }

                    // Create impact particles
                    createImpactParticles(cube.position.clone(), axis);
                }
            }

            // Update trail
            if (trails[i]) {
                const trail = trails[i];
                trail.updateCounter++;

                if (trail.updateCounter >= 3) { // Update every few frames for performance
                    trail.updateCounter = 0;
                    trail.points.shift(); // Remove oldest point
                    trail.points.push(cube.position.clone()); // Add current position

                    // Update trail geometry
                    trail.line.geometry.setFromPoints(trail.points);
                    trail.line.geometry.attributes.position.needsUpdate = true;

                    // Fade trail based on speed
                    const speedFactor = THREE.MathUtils.clamp(vel.length() / maxSpeed, 0.1, 1);
                    trail.line.material.opacity = 0.4 * speedFactor;
                }
            }
        }

        // Handle collisions between cubes with improved physics
        for (let i = 0; i < cubeGroups.length; i++) {
            for (let j = i + 1; j < cubeGroups.length; j++) {
                // Skip collision if either cube is being dragged
                if ((isDragging && selectedCube === i) || (isDragging && selectedCube === j)) {
                    continue;
                }

                const cubeA = cubeGroups[i];
                const cubeB = cubeGroups[j];
                const velA = velocities[i];
                const velB = velocities[j];
                const angVelA = angularVelocities[i];
                const angVelB = angularVelocities[j];
                const radiusA = cubeA.userData.boundingRadius;
                const radiusB = cubeB.userData.boundingRadius;
                const massA = cubeA.userData.mass || 1.0;
                const massB = cubeB.userData.mass || 1.0;

                const diff = new THREE.Vector3().subVectors(
                    cubeA.position,
                    cubeB.position
                );
                const distance = diff.length();
                const minDistance = radiusA + radiusB;

                if (distance < minDistance) {
                    // Collision normal
                    const normal = diff.normalize();

                    // Overlap correction - prevent objects from intersecting
                    const overlap = minDistance - distance;
                    const totalMass = massA + massB;
                    const ratioA = massB / totalMass;
                    const ratioB = massA / totalMass;

                    // Move cubes apart based on their mass
                    const correctionA = normal.clone().multiplyScalar(overlap * ratioA);
                    const correctionB = normal.clone().multiplyScalar(-overlap * ratioB);

                    cubeA.position.add(correctionA);
                    cubeB.position.add(correctionB);

                    // Relative velocity
                    const relativeVelocity = new THREE.Vector3().subVectors(
                        velA,
                        velB
                    );

                    // Velocity component along normal
                    const speedAlongNormal = relativeVelocity.dot(normal);

                    // Only resolve if objects moving toward each other
                    if (speedAlongNormal < 0) {
                        // Calculate impulse using conservation of momentum
                        const restitution = 1.0 + collisionDamping; // Bounciness
                        const impulseMagnitude = -(restitution * speedAlongNormal) /
                            (1 / massA + 1 / massB);

                        const impulse = normal.clone().multiplyScalar(impulseMagnitude);

                        // Apply impulse based on mass
                        velA.add(impulse.clone().multiplyScalar(1 / massA));
                        velB.sub(impulse.clone().multiplyScalar(1 / massB));

                        // Calculate angular impulse for more realistic rotation
                        const collisionPointA = normal.clone().multiplyScalar(-radiusA * 0.8);
                        const collisionPointB = normal.clone().multiplyScalar(radiusB * 0.8);

                        // Cross product to get torque direction
                        const torqueA = new THREE.Vector3().crossVectors(
                            collisionPointA,
                            impulse
                        ).multiplyScalar(0.05 / massA);

                        const torqueB = new THREE.Vector3().crossVectors(
                            collisionPointB,
                            impulse
                        ).multiplyScalar(0.05 / massB);

                        // Apply torque as angular velocity change
                        angVelA.add(torqueA);
                        angVelB.add(torqueB);

                        // Play collision sound based on impact force
                        if (speedAlongNormal < -0.1) {
                            playCollisionSound();
                        }

                        // Create collision particles
                        const collisionPoint = new THREE.Vector3().addVectors(
                            cubeA.position,
                            collisionPointA
                        );
                        createCollisionParticles(collisionPoint);
                    }
                }
            }
        }

        // Render the scene
        renderer.render(scene, camera);
    }

    // Create impact particles when hitting walls
    function createImpactParticles(position, axis) {
        const particleCount = 10;
        const particleGroup = new THREE.Group();
        scene.add(particleGroup);

        for (let i = 0; i < particleCount; i++) {
            const size = Math.random() * 0.3 + 0.1;
            const geometry = new THREE.SphereGeometry(size, 8, 8);

            // Random color based on current theme
            const colors = [0x00ffff, 0xff00ff, 0xffff00];
            const material = new THREE.MeshBasicMaterial({
                color: colors[Math.floor(Math.random() * colors.length)],
                transparent: true,
                opacity: 0.8
            });

            const particle = new THREE.Mesh(geometry, material);
            particle.position.copy(position);

            // Set velocity direction based on impact axis
            const velocity = new THREE.Vector3(
                THREE.MathUtils.randFloatSpread(0.2),
                THREE.MathUtils.randFloatSpread(0.2),
                THREE.MathUtils.randFloatSpread(0.2)
            );

            // Ensure particles move away from the wall or shockwave
            if (axis === 'x') {
                velocity.x = Math.sign(position.x) * -Math.abs(velocity.x) * 2;
            } else if (axis === 'y') {
                velocity.y = Math.sign(position.y) * -Math.abs(velocity.y) * 2;
            } else if (axis === 'z') {
                velocity.z = Math.sign(position.z) * -Math.abs(velocity.z) * 2;
            } else if (axis === 'shockwave') {
                // For shockwave, particles move in random directions but faster
                velocity.multiplyScalar(3);
            }

            particle.userData.velocity = velocity;
            particle.userData.life = 1.0;

            particleGroup.add(particle);
        }

        // Animate particles
        const startTime = Date.now();
        const duration = 1000; // ms

        function animateParticles() {
            const elapsed = Date.now() - startTime;
            const progress = elapsed / duration;

            if (progress < 1) {
                particleGroup.children.forEach(particle => {
                    particle.position.add(particle.userData.velocity);
                    particle.userData.velocity.y -= 0.01; // Gravity
                    particle.userData.life -= 0.02;
                    particle.material.opacity = particle.userData.life;
                    particle.scale.multiplyScalar(0.98);
                });

                requestAnimationFrame(animateParticles);
            } else {
                scene.remove(particleGroup);
            }
        }

        animateParticles();
    }

    // Create particles for cube collisions
    function createCollisionParticles(position) {
        const particleCount = 15;
        const particleGroup = new THREE.Group();
        scene.add(particleGroup);

        for (let i = 0; i < particleCount; i++) {
            const size = Math.random() * 0.2 + 0.05;
            const geometry = new THREE.SphereGeometry(size, 8, 8);

            // Random color from neon palette
            const colors = [0x00ffff, 0xff00ff, 0xffff00, 0x00ff00];
            const material = new THREE.MeshBasicMaterial({
                color: colors[Math.floor(Math.random() * colors.length)],
                transparent: true,
                opacity: 0.8
            });

            const particle = new THREE.Mesh(geometry, material);
            particle.position.copy(position);

            // Random velocity in all directions
            const velocity = new THREE.Vector3(
                THREE.MathUtils.randFloatSpread(0.3),
                THREE.MathUtils.randFloatSpread(0.3),
                THREE.MathUtils.randFloatSpread(0.3)
            );

            particle.userData.velocity = velocity;
            particle.userData.life = 1.0;

            particleGroup.add(particle);
        }

        // Animate particles
        const startTime = Date.now();
        const duration = 800; // ms

        function animateParticles() {
            const elapsed = Date.now() - startTime;
            const progress = elapsed / duration;

            if (progress < 1) {
                particleGroup.children.forEach(particle => {
                    particle.position.add(particle.userData.velocity);
                    particle.userData.life -= 0.03;
                    particle.material.opacity = particle.userData.life;
                });

                requestAnimationFrame(animateParticles);
            } else {
                scene.remove(particleGroup);
            }
        }

        animateParticles();
    }

    // UI controls
    document.getElementById('theme-toggle').addEventListener('click', () => {
        // Cycle through background themes
        const themes = ['space', 'underwater', 'neon', 'mixed'];
        const currentTheme = document.body.getAttribute('data-theme') || 'mixed';
        const currentIndex = themes.indexOf(currentTheme);
        const nextIndex = (currentIndex + 1) % themes.length;
        const nextTheme = themes[nextIndex];

        document.body.setAttribute('data-theme', nextTheme);

        // Update visuals based on theme
        updateTheme(nextTheme);
    });

    document.getElementById('add-cube').addEventListener('click', () => {
        createCube();
    });

    document.getElementById('reset').addEventListener('click', () => {
        // Remove all cubes
        for (let i = cubeGroups.length - 1; i >= 0; i--) {
            scene.remove(cubeGroups[i]);
            scene.remove(trails[i].line);
        }

        cubeGroups.length = 0;
        velocities.length = 0;
        angularVelocities.length = 0;
        trails.length = 0;

        // Create new cubes
        createInitialCubes();
    });

    document.getElementById('particle-style').addEventListener('change', (e) => {
        updateTheme(e.target.value);
    });

    function updateTheme(theme) {
        // Update particle visibility
        switch (theme) {
            case 'bubbles':
                bubbleGroup.visible = true;
                stars.visible = false;
                neonParticles.visible = false;
                break;
            case 'stars':
                bubbleGroup.visible = false;
                stars.visible = true;
                neonParticles.visible = false;
                break;
            case 'neon':
                bubbleGroup.visible = false;
                stars.visible = false;
                neonParticles.visible = true;
                break;
            case 'mixed':
            default:
                bubbleGroup.visible = true;
                stars.visible = true;
                neonParticles.visible = true;
                break;
        }
    }

    // Start animation
    animate();

    // Handle window resize
    window.addEventListener("resize", () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
    });
    </script>
</body>

</html>