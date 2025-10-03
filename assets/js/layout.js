console.log('layout.js loaded');

let lastScrollTop = 0;
const header    = document.querySelector('.page-header');
const footer    = document.querySelector('.fixed-footer');
const toggleBtn = document.querySelector('.menu-toggle');
const nav       = document.querySelector('.page-nav');
const heroVideo = document.querySelector('.hero-video');
const heroImage = document.querySelector('.hero-image-fallback');
const hour      = new Date().getHours();

// Ensure BASE_URL is defined in your HTML before this script runs:
// <script>const BASE_URL = "<?= BASE_URL ?>";</script>

// ===== Mobile nav toggle with aria-expanded updates =====
// if (toggleBtn && nav) {
//   toggleBtn.addEventListener('click', () => {
//     const isOpen = nav.classList.toggle('open');
//     toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
//   });
// }

// ===== Click outside to close mobile menu =====
document.addEventListener('click', (e) => {
  if (
    nav.classList.contains('open') &&
    !nav.contains(e.target) &&
    e.target !== toggleBtn
  ) {
    nav.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
  }
});

// ===== Reset menu state on resize =====
window.addEventListener('resize', () => {
  if (window.innerWidth >= 768) {
    nav.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
  }
  setHeroMedia();
});

// ===== Scroll-aware header + footer =====
window.addEventListener('scroll', () => {
  const st = window.pageYOffset || document.documentElement.scrollTop;

  if (st > lastScrollTop) {
    // scrolling down → hide header + footer
    header?.classList.add('hide');
    footer?.classList.remove('show');
  } else {
    // scrolling up → show header + footer
    header?.classList.remove('hide');
    footer?.classList.add('show');
  }

  lastScrollTop = st <= 0 ? 0 : st;
});

// Initial state: footer visible on load
footer?.classList.add('show');

// ===== Hero media logic =====
function setHeroMedia() {
  if (window.innerWidth >= 768 && heroVideo) {
    heroVideo.style.display = 'block';
    if (heroImage) heroImage.style.display = 'none';
  } else if (heroImage) {
    heroImage.style.display = 'block';
    if (heroVideo) heroVideo.style.display = 'none';

    // Optional: swap image based on time of day
    if (hour < 12) {
      heroImage.src = BASE_URL + '/assets/images/hdog11.jpg';
    } else {
      heroImage.src = BASE_URL + '/assets/images/hdog11.jpg';
    }
  }
}

// Run hero media setup on load
setHeroMedia();

/* ============================
   DOG CARDS CAROUSEL (new logic)
   ============================ */
const dogsTrack = document.querySelector('.dogs-carousel .carousel-track');
const dogsCards = document.querySelectorAll('.dogs-carousel .carousel-card');
const dogsPrevBtn = document.querySelector('.dogs-carousel .carousel-control.prev');
const dogsNextBtn = document.querySelector('.dogs-carousel .carousel-control.next');

if (dogsTrack && dogsCards.length > 0) {
  let visibleCards = getVisibleCards();
  let index = 0;
  const totalCards = dogsCards.length;

  function getVisibleCards() {
    if (window.innerWidth <= 576) return 1;
    if (window.innerWidth <= 768) return 2;
    if (window.innerWidth <= 992) return 3;
    return 4;
  }

  function updateDogsCarousel() {
    visibleCards = getVisibleCards(); // recalc on resize
    const cardWidth = dogsCards[0].offsetWidth;
    dogsTrack.style.transform = `translateX(-${index * cardWidth}px)`;
  }

  function nextCard() {
    if (index < totalCards - visibleCards) {
      index++;
    } else {
      index = 0; // loop back
    }
    updateDogsCarousel();
  }

  function prevCard() {
    if (index > 0) {
      index--;
    } else {
      index = totalCards - visibleCards;
    }
    updateDogsCarousel();
  }

  dogsNextBtn?.addEventListener('click', () => {
    nextCard();
    resetAutoScroll();
  });

  dogsPrevBtn?.addEventListener('click', () => {
    prevCard();
    resetAutoScroll();
  });

  let autoScroll = setInterval(nextCard, 3000);

  function resetAutoScroll() {
    clearInterval(autoScroll);
    autoScroll = setInterval(nextCard, 3000);
  }

  window.addEventListener('resize', () => {
    index = 0;
    updateDogsCarousel();
  });

  updateDogsCarousel();
}

/* ============================
   END DOG CARDS CAROUSEL
   ============================ */

function getAgeText(dobString) {
  const dob = new Date(dobString);
  const now = new Date();
  const diff = now - dob;
  const ageDate = new Date(diff);
  const years = ageDate.getUTCFullYear() - 1970;
  const months = ageDate.getUTCMonth();

  if (years > 0) return `${years} yrs`;
  if (months > 0) return `${months} months`;
  return `Less than a month`;
}

document.querySelectorAll('.dog-card').forEach(card => {
  const angle = (Math.random() * 4 - 2).toFixed(2); // -2 to +2 degrees
  card.classList.add('tilted');
  card.style.setProperty('--tilt-angle', `${angle}deg`);
});

// FOOTER ITEMS CHANGED INTO DROPDOWN AS SCREEN GETS SMALLER
document.addEventListener('DOMContentLoaded', () => {
  const moreToggle = document.querySelector('.more-toggle');
  const moreMenu = document.getElementById('footerMenuMore');
  const allToggle = document.querySelector('.all-toggle');
  const allMenu = document.getElementById('footerMenuAll');

  if (moreToggle && moreMenu) {
    moreToggle.addEventListener('click', () => {
      moreMenu.classList.toggle('show');
      const expanded = moreToggle.getAttribute('aria-expanded') === 'true';
      moreToggle.setAttribute('aria-expanded', String(!expanded));
    });
  }

  if (allToggle && allMenu) {
    allToggle.addEventListener('click', () => {
      allMenu.classList.toggle('show');
      const expanded = allToggle.getAttribute('aria-expanded') === 'true';
      allToggle.setAttribute('aria-expanded', String(!expanded));
    });
  }
});

/* ============================
   DOG INFO (overlay + inline)
   ============================ */
   const section       = document.getElementById("dogInfoSection");
   const nameEl        = document.getElementById("dogInfoName");
   const storyEl       = document.getElementById("dogInfoStory");
   const mainImg       = document.querySelector("#dogInfoImages .main-dog-img");
   const subImages     = document.querySelector("#dogInfoImages .dog-sub-images");
   const fosterBtn     = document.getElementById("fosterBtn");
   const adoptBtnInline= document.getElementById("adoptBtnInline");
   const backBtn       = document.getElementById("backBtn");
   
   // Overlay elements
   const formOverlay   = document.getElementById("dogForm");
   const dogInfoImg    = document.getElementById("dogInfoImg");
   const adoptBtn      = document.getElementById("adoptBtn");
   const closeBtn      = document.querySelector(".close-form-btn");

  // Ensure that no duplicate icon is shown in the empty iamge wrappers
   function shuffleArray(arr) {
    return arr
      .map(value => ({ value, sort: Math.random() }))
      .sort((a, b) => a.sort - b.sort)
      .map(({ value }) => value);
  }
   
   // Shared function
   function populateDogInfo(data, mode = "inline") {
    // Fill inline section
    if (nameEl) nameEl.textContent = data.name ? `${data.name}'s Story ` : "";
    if (storyEl) storyEl.innerHTML = data.story || `${data.name}'s story is comming soon...`;
    if (mainImg) mainImg.src = data.img || "";
  
    if (subImages) {
      subImages.innerHTML = "";
  
      // Collect extra images if available
      let urls = [];
      if (data.extra) {
        urls = data.extra
          .split(",")
          .map(s => s.trim())
          .filter(Boolean);
      }
  
      // Always ensure 4 slots
      const totalNeeded = 4;
      const defaultImg = "assets/images/default-dog.jpg"; // <-- your fallback path
      
      const placeholderIcons = [
        "assets/images/icons/Doggy2.jpg",
        "assets/images/icons/Doggy2.png",
        "assets/images/icons/Doggy3.jpg",
        "assets/images/icons/Doggy.jpg"
      ];  
          
          
      for (let i = 0; i < totalNeeded; i++) {
        const wrapper = document.createElement("div");
        wrapper.classList.add("sub-image-wrapper");
      
        const img = document.createElement("img");
      
        if (i < urls.length) {
          // Real image
          img.src = urls[i];
          img.alt = `${data.name} photo`;
        } else {
          // Placeholder slot → pick a random icon
          const iconIndex = Math.floor(Math.random() * placeholderIcons.length);
          img.src = placeholderIcons[iconIndex];
          img.alt = "Placeholder icon";
          wrapper.classList.add("placeholder");
        }
      
        wrapper.appendChild(img);
        subImages.appendChild(wrapper);
      }
  
    if (fosterBtn) fosterBtn.href = data.fosterUrl || "#";
    if (adoptBtnInline) adoptBtnInline.href = data.adoptUrl || "#";
  
    if (mode === "inline" && section) {
      section.classList.remove("d-none");
      section.scrollIntoView({ behavior: "smooth" });
    }
  
    if (mode === "overlay" && formOverlay) {
      if (dogInfoImg) dogInfoImg.src = data.img || "";
      if (adoptBtn) adoptBtn.href = data.adoptUrl || "#";
      formOverlay.style.display = "flex";
    }
  }
} 
   


   const carousel = document.getElementById("dogCardCarousel");
   const adoptionProcess = document.getElementById("adoptionProcess");

   
// When user clicks "View More"
document.querySelectorAll(".view-more-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    populateDogInfo({
      name: btn.dataset.name,
      story: btn.dataset.story,
      img: btn.dataset.img,
      extra: btn.dataset.extra,
      fosterUrl: btn.dataset.foster,
      adoptUrl: btn.dataset.adopt
    }, "inline");

    // hide carousel
    if (carousel) carousel.classList.add("d-none");
    if (adoptionProcess) adoptionProcess.classList.add("d-none");
  });
});
   
   // Wire up overlay buttons
   document.querySelectorAll(".open-form-btn").forEach(btn => {
     btn.addEventListener("click", () => {
       populateDogInfo({
         name: btn.dataset.name,
         story: btn.dataset.story,
         img: btn.dataset.img,
         extra: btn.dataset.extra,
         fosterUrl: btn.dataset.foster,
         adoptUrl: btn.dataset.adopt
       }, "overlay");
     });
   });
   
   // Back button hides inline section
   if (backBtn) {
    backBtn.addEventListener("click", () => {
      section?.classList.add("d-none");
      if (carousel) carousel.classList.remove("d-none"); // show carousel again
      if (adoptionProcess) adoptionProcess.classList.remove("d-none"); // show adoptionProcess again
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }  
   
   // Close overlay
   if (closeBtn) {
     closeBtn.addEventListener("click", () => {
       formOverlay.style.display = "none";
       if (dogInfoImg) dogInfoImg.src = "";
       if (adoptBtn) adoptBtn.href = "#";
     });
   }

   // Adoption process button to move down to blog section for adoption process
   document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("adoptionProcessBtn");
    const target = document.getElementById("adoptionProcess");
  
    if (!btn || !target) return;
  
    btn.addEventListener("click", event => {
      event.preventDefault();                     // Stop the default jump
      if (target) target.classList.remove("d-none");

      target.scrollIntoView({ 
        behavior: "smooth",                       // Animate the scroll
        block: "start"                            // Align top of section
      });
    });
  });

  // Payment Info Modal
  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("infoModal");
    const openBtn = document.getElementById("openPaymentModal");
    const openBtn2 = document.getElementById("openPaymentModal2");
    const closeBtn = document.getElementById("closeInfoModal");
    const backBtn = document.getElementById("modalBackBtn");
  
    if (openBtn && modal) {
      openBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = "flex";
      });
    }

    if (openBtn2) {
      openBtn2.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = "flex";
      });
    }
  
    if (closeBtn) {
      closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
      });
    }
  
    if (backBtn) {
      backBtn.addEventListener("click", () => {
        modal.style.display = "none";
      });
    }
  
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
      }
    });
  });