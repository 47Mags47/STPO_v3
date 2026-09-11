import axios from "axios";

let enabled = false;
let gameEnabled = false;

let container = null;
let bucket = null;
let scoreElement = null;

let score = 0;
let mouseX = 0;
let mouseY = 0;

const MAX_ITEMS = 30;

const seasons = {
    spring: ['🌸', '🌷', '🌼'],
    summer: ['☀️', '🌷'],
    winter: ['❄', '❅', '❆'],
    autumn: ['🍂', '🍁'],
};

function showGamePreview() {
    const season = getCurrentSeason();

    if (!season) return;

    const previewData = {
        spring: {
            title: 'Поймай цветы!',
            text: 'Двигай мышкой и собирай падающие цветы',
            score: '+1 за каждый пойманный цветок',
        },

        summer: {
            title: 'Поймай солнышки и цветы!',
            text: 'Двигай мышкой и собирай летнее настроение!',
            score: '+1 за каждое пойманное солнце или цветок!',
        },

        autumn: {
            title: 'Поймай листья!',
            text: 'Двигай мышкой и собирай падающие листья',
            score: '+1 за каждый пойманный лист',
        },

        winter: {
            title: 'Поймай снежинки!',
            text: 'Двигай мышкой и собирай падающие снежинки',
            score: '+1 за каждую пойманную снежинку',
        },
    };

    const data = previewData[season];

    const preview = document.createElement('div');

    preview.className = 'season-game-preview';

    preview.innerHTML = `
        <div class="preview-icon">🪣</div>
        <div class="preview-title">${data.title}</div>
        <div class="preview-text">${data.text}</div>
        <div class="preview-score">${data.score}</div>
    `;

    document.body.appendChild(preview);

    setTimeout(() => {
        preview.classList.add('hide');

        setTimeout(() => {
            preview.remove();
        }, 400);
    }, 2500);
}

export function getCurrentSeason() {
    const month = new Date().getMonth() + 1;

    if (month >= 3 && month <= 5) return 'spring';
    if (month >= 6 && month <= 8) return 'summer';
    if (month >= 9 && month <= 11) return 'autumn';
    if (month === 12 || month <= 2) return 'winter';

    return null;
}

export function initSeason() {
    if (container) return;

    container = document.createElement('div');
    container.className = 'season-effect';

    document.body.appendChild(container);

    document.addEventListener('mousemove', handleMouseMove);
}

function handleMouseMove(event) {
    mouseX = event.clientX;
    mouseY = event.clientY;

    if (!gameEnabled || !bucket) {
        return;
    }

    bucket.style.left = `${mouseX}px`;
    bucket.style.top = `${mouseY}px`;

    checkCollisions();
}

function createBucket() {
    if (bucket) return;

    bucket = document.createElement('div');
    bucket.className = 'season-bucket';

    bucket.innerHTML = `
        <span class="bucket">🪣</span>
        <span class="score">0</span>
    `;

    document.body.appendChild(bucket);

    scoreElement = bucket.querySelector('.score');
}

function removeBucket() {
    bucket?.remove();

    bucket = null;
    scoreElement = null;
}

function checkCollisions() {
    if (!bucket) return;

    const bucketRect = bucket.getBoundingClientRect();

    container.querySelectorAll('.season-item').forEach(item => {
        const itemRect = item.getBoundingClientRect();

        const collision =
            itemRect.left < bucketRect.right &&
            itemRect.right > bucketRect.left &&
            itemRect.top < bucketRect.bottom &&
            itemRect.bottom > bucketRect.top;

        if (collision) {
            catchItem(item);
        }
    });
}

function catchItem(item) {
    item.remove();

    score++;

    if (scoreElement) {
        scoreElement.textContent = score;
    }

    createItem();
}

function createItem() {
    const season = getCurrentSeason();

    if (!season || !gameEnabled) return;

    const items = seasons[season];

    const item = document.createElement('div');

    item.className = `season-item ${season}`;

    item.textContent = items[
        Math.floor(Math.random() * items.length)
    ];

    item.style.left = `${Math.random() * 98}%`;

    item.style.animationDelay = `${Math.random() * 12}s`;
    item.style.animationDuration = `${12 + Math.random() * 13}s`;

    item.style.fontSize = `${14 + Math.random() * 16}px`;

    item.addEventListener('animationend', () => {
        // Если лист всё ещё существует — он вышел за экран
        if (item.isConnected) {
            item.remove();

            // Создаём новый лист
            createItem();
        }
    });

    container.appendChild(item);
}

function createItems() {
    for (let i = 0; i < MAX_ITEMS; i++) {
        createItem();
    }
}

export function toggleSeason() {
    enabled = !enabled;
    gameEnabled = enabled;

    container?.classList.toggle('active', enabled);

    if (gameEnabled) {
        container.innerHTML = '';

        score = 0;

        createItems();
        createBucket();
        createEndGameButton();

        showGamePreview();
    } else {
        container.innerHTML = '';

        removeBucket();
        removeEndGameButton();
    }
}

function createEndGameButton() {
    const button = document.createElement('button');

    button.className = 'season-end-game';
    button.textContent = 'Закончить игру';

    button.addEventListener('click', () => {
        endGame();
    });

    document.body.appendChild(button);
}

function removeEndGameButton() {
    document.querySelector('.season-end-game')?.remove();
}

function endGame() {
    enabled = false;
    gameEnabled = false;

    container?.classList.remove('active');
    container.innerHTML = '';

    removeBucket();
    removeEndGameButton();

    axios.post(route('update-score'), {
        score: score
    })
}
