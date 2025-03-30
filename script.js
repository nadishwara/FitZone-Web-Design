document.addEventListener('DOMContentLoaded', function() {
    const scrollContent = document.querySelector('.scroll-content');
    // const pauseBtn = document.getElementById('pauseBtn');
    // const reverseBtn = document.getElementById('reverseBtn');
    
    // let isPaused = false;
    // let isReversed = false;
    
    // Pause/Play functionality
    pauseBtn.addEventListener('click', function() {
    });
    
    // Reverse direction functionality
    reverseBtn.addEventListener('click', function() {
    });
    
    // Reset animation when it completes to create infinite loop
    scrollContent.addEventListener('animationiteration', function() {
      if (!isReversed) {
        // When reaching the duplicate set, jump back to start seamlessly
        const firstImg = scrollContent.querySelector('img');
        const firstImgWidth = firstImg.offsetWidth + 20; // 20px for padding
        
        if (scrollContent.getBoundingClientRect().left < -firstImgWidth * 4) {
          scrollContent.style.animation = 'none';
          scrollContent.offsetHeight; // Trigger reflow
          scrollContent.style.animation = 'scroll 30s linear infinite';
          if (isReversed) {
            scrollContent.style.animationDirection = 'reverse';
          }
        }
      }
    });
  });