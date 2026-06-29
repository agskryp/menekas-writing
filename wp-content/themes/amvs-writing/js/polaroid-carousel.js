const container = document.getElementById('carousel');
const cards = document.querySelectorAll('.polaroid');
let currentIndex = 0;
let autoplayTimer = null;

const randomRange = (min, max) => Math.random() * (max - min) + min;

function updateCarouselState() {
  cards.forEach((card, index) => {
    // 1. Current active photo on top
    if (index === currentIndex) {
      card.classList.add('active');
      card.style.transform = `translate3d(0, 0, 0) rotate(0deg)`;
      card.style.opacity = "1";
      card.style.zIndex = "10";
    } 
    // 2. Background photos stacked behind it
    else {
      card.classList.remove('active');
      
      let distance = index - currentIndex;
      if (distance < 0) distance += cards.length;
      
      const randomX = randomRange(-12, 12);
      const randomY = randomRange(-8, 12);
      const randomDeg = randomRange(-6, 6);
      
      card.style.transform = `translate3d(${randomX}px, ${randomY}px, -${distance * 10}px) rotate(${randomDeg}deg)`;
      card.style.opacity = distance === cards.length - 1 ? "0" : "0.85";
      card.style.zIndex = 10 - distance;
    }
  });
}

function rotateCards() {
  const previousCard = cards[currentIndex];
  
  // Generate a random exit trajectory vector
  const angle = randomRange(0, 2 * Math.PI); // Full 360 degree options
  const distance = 400; // Distance in pixels to fly out of container view
  
  const exitX = Math.cos(angle) * distance;
  const exitY = Math.sin(angle) * distance;
  const exitRotation = randomRange(-35, 35); // Random spin angle

  // Apply the random exit styling dynamically
  previousCard.style.opacity = "0";
  previousCard.style.transform = `translate3d(${exitX}px, ${exitY}px, 50px) rotate(${exitRotation}deg)`;
  
  // Wait for slide-out animation to finish before snapping to the bottom of the pile
  setTimeout(() => {
    currentIndex = (currentIndex + 1) % cards.length;
    updateCarouselState();
  }, 350); 
}

// Autoplay triggers
function startAutoplay() {
  if (!autoplayTimer) autoplayTimer = setInterval(rotateCards, 6000);
}

// function stopAutoplay() {
//   clearInterval(autoplayTimer);
//   autoplayTimer = null;
// }

// container.addEventListener('mouseenter', stopAutoplay);
// container.addEventListener('mouseleave', startAutoplay);

// Run initialization
updateCarouselState();
startAutoplay();
