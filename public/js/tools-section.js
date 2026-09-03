// List of tools shown in the ticker. Edit freely — order here is scroll order.
const tools = [
    ["Seedance 2.5", "VIDEO GENERATION"],
    ["Seedance 2.5 Edit", "VIDEO EDITING"],
    ["Seedance 2.0", "VIDEO GENERATION"],
    ["Seedance 2.0 Fast", "VIDEO GENERATION"],
    ["Seedance 2.0 Mini", "VIDEO GENERATION"],
    ["MiniMax H3", "VIDEO GENERATION"],
    ["Gemini Omni Flash", "MULTIMODAL AI"],
    ["Kling 3.0", "VIDEO GENERATION"],
    ["FLUX.3 Video", "VIDEO GENERATION"],
    ["Grok Imagine 1.5", "IMAGE & VIDEO"],
    ["Minimax Hailuo", "VIDEO GENERATION"],
    ["Kling", "VIDEO GENERATION"],
    ["OpenAI Sora 2", "VIDEO GENERATION"],
    ["Google Veo", "VIDEO GENERATION"],
    ["Higgsfield", "SCENE & MOTION"],
    ["Wan", "VIDEO GENERATION"],
    ["Seedance", "VIDEO GENERATION"],
    ["Grok Imagine", "IMAGE GENERATION"],
    ["HappyHorse", "VOICE & AUDIO"]
];

function renderTicker() {
    const track = document.getElementById('track');
    if (!track) return;

    const itemsHTML = tools
        .map(([name, label]) => `
      <div class="tools-item">
        <span class="tools-dot"></span>
        <span class="tools-name">${name}</span>
        <span class="tools-label">${label}</span>
      </div>
    `)
        .join('');

    // Render the list twice back-to-back so translateX(-50%) loops seamlessly.
    track.innerHTML = itemsHTML + itemsHTML;
}

document.addEventListener('DOMContentLoaded', renderTicker);