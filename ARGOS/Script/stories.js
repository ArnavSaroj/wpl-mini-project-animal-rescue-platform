// Happy Tails slider logic

document.addEventListener("DOMContentLoaded", () => {
  const storySection = document.querySelector(".stories-section");
  if (!storySection) return;

  const card = storySection.querySelector(".story-card");
  const img = card?.querySelector(".story-image img");
  const titleEl = card?.querySelector(".story-content h3");
  const quoteEl = card?.querySelector(".story-content p");
  const adopterEl = card?.querySelector(".story-content .adopter");
  const prevBtn = storySection.querySelector(".story-prev");
  const nextBtn = storySection.querySelector(".story-next");

  if (!card || !img || !titleEl || !quoteEl || !adopterEl) return;

  // Stories data: update imageSrc values when you have your own images
  const stories = [
    {
      imageSrc:
        "https://hips.hearstapps.com/hmg-prod/images/dog-puppy-on-garden-royalty-free-image-1586966191.jpg?crop=0.752xw:1.00xh;0.175xw,0&resize=1200:*",
      imageAlt: "Happy dog with adopter",
      title: "Nala's First Soft Bed",
      quote:
        '"Nala came to us scared and skinny. Thanks to Argos she now owns every couch cushion in the house and greets us with the happiest wiggle."',
      adopter: "- The Samadhiya Family",
    },
    {
      imageSrc:
        "https://a-z-animals.com/media/animals/images/original/dog3.jpg",
      imageAlt: "Adopted puppy with child",
      title: "Bruno Finds His Player Two",
      quote:
        '"Bruno was listed on Argos as a high-energy pup. He turned out to be the perfect match for our game-loving twins and joins every backyard adventure."',
      adopter: "- The D'Souza Family",
    },
    {
      imageSrc:
        "https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?auto=format&fit=crop&w=800",
      imageAlt: "Cat relaxing at new home",
      title: "Misty's Window Kingdom",
      quote:
        '"Misty was rescued during the monsoon. Now she rules the window seat, watching birds all day while we work from home beside her."',
      adopter: "- Kavya & Rohan",
    },
  ];

  let current = 0;
  let timerId = null;

  function renderStory(index) {
    const story = stories[index];
    img.src = story.imageSrc;
    img.alt = story.imageAlt;
    titleEl.textContent = story.title;
    quoteEl.textContent = story.quote;
    adopterEl.textContent = story.adopter;
  }

  function showNext() {
    current = (current + 1) % stories.length;
    renderStory(current);
  }

  function showPrev() {
    current = (current - 1 + stories.length) % stories.length;
    renderStory(current);
  }

  function resetTimer() {
    if (timerId) clearInterval(timerId);
    timerId = setInterval(showNext, 7000); // auto-cycle every 7s
  }

  // Initial render (syncs with JS data)
  renderStory(current);
  resetTimer();

  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      showNext();
      resetTimer();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      showPrev();
      resetTimer();
    });
  }
});
