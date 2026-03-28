// Adopt page specific logic: dynamically render pet cards and handle profile toggle

document.addEventListener("DOMContentLoaded", () => {
  const petGrid = document.querySelector(".adopt-section .pet-grid");
  if (!petGrid) return; // run only on adopt page

  // Static pet data; each mapped to an image in public/images
  const pets = [
    {
      id: "rocky",
      name: "Rocky",
      breed: "Doberman",
      age: "8 Years",
      gender: "Male",
      badgeClass: "new",
      badgeText: "New Rescue",
      imageSrc: "./public/images/1.png",
      imageAlt: "Rocky the Doggy",
      description:
        "Rocky served  a long successfull carrer in the police forces and now he is looking for a good home to adopt him after retiring.",
      points: [
        "Vaccination: Up to date",
        "Temperament: Friendly, good with kids",
        "Special notes: Needs daily exercise",
      ],
    },
    {
      id: "roxa",
      name: "Roxa",
      breed: "Egpytian Cat",
      age: "1 Year",
      gender: "Female",
      badgeClass: "healthy",
      badgeText: "Healthy",
      imageSrc: "./public/images/2.png",
      imageAlt: "Roxa the Cat",
      description:
        "Roxa is a calm, affectionate cat who loves window-watching and quiet naps. Perfect for apartments and first-time adopters.",
      points: [
        "Vaccination: Complete",
        "Temperament: Gentle, shy at first",
        "Special notes: Indoor-only home preferred",
      ],
    },
    {
      id: "choppy",
      name: "Choppy",
      breed: "Bulldog",
      age: "5 Years",
      gender: "Male",
      badgeClass: "special",
      badgeText: "Special Care",
      imageSrc: "./public/images/3.png",
      imageAlt: "Choppy the Bulldog",
      description:
        "Choppy is a gentle soul who needs a bit of extra medical care for his joints, but he rewards you with endless cuddles.",
      points: [
        "Vaccination: Up to date",
        "Temperament: Calm, affectionate",
        "Special notes: Needs low-impact exercise and regular vet checkups",
      ],
    },
    {
      id: "Lola",
      name: "Coco",
      breed: "Sphyinx",
      age: "3 Years",
      gender: "Female",
      badgeClass: "healthy",
      badgeText: "Ready for Home",
      imageSrc: "./public/images/4.png",
      imageAlt: "Coco the Mixed Breed",
      description:
        "Lola is very social and loves being around people. She learns new commands quickly and is eager to please.",
      points: [
        "Vaccination: Complete",
        "Temperament: Energetic, social",
        "Special notes: Best with an active family",
      ],
    },
    // Animals also shown on the home page (index.html)
    {
      id: "buddy",
      name: "Buddy",
      breed: "Beagle",
      age: "2 Years",
      gender: "Male",
      badgeClass: "new",
      badgeText: "New Rescue",
      imageSrc:
        "https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=500",
      imageAlt: "Buddy the Beagle",
      description:
        "Buddy is an energetic Beagle who loves sniffing around the park and playing fetch. He is social and great with families.",
      points: [
        "Vaccination: Up to date",
        "Temperament: Very friendly, kid-safe",
        "Special notes: Needs regular walks and mental games",
      ],
    },
    {
      id: "luna",
      name: "Luna",
      breed: "Calico Cat",
      age: "1 Year",
      gender: "Female",
      badgeClass: "healthy",
      badgeText: "Healthy",
      imageSrc:
        "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=500",
      imageAlt: "Luna the Calico Cat",
      description:
        "Luna is a curious Calico who enjoys sunbathing and watching birds from the window. She warms up quickly once she trusts you.",
      points: [
        "Vaccination: Complete",
        "Temperament: Gentle, slightly shy at first",
        "Special notes: Indoor-only home preferred",
      ],
    },
    {
      id: "max",
      name: "Max",
      breed: "Bull Dog",
      age: "5 Years",
      gender: "Male",
      badgeClass: "special",
      badgeText: "Special Care",
      imageSrc:
        "https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=500",
      imageAlt: "Max the Bulldog",
      description:
        "Max is a loving Bulldog who prefers short walks and long naps. He is a bit sensitive to heat and needs a cool place to rest.",
      points: [
        "Vaccination: Up to date",
        "Temperament: Calm, cuddly",
        "Special notes: Needs low-impact exercise and shade in summer",
      ],
    },
  ];
  petGrid.innerHTML = pets
    .map(
      (pet) => `
        <div class="pet-card">
          <div class="pet-image">
            <img src="${pet.imageSrc}" alt="${pet.imageAlt}">
            ${pet.badgeText ? `<span class="badge ${pet.badgeClass}">${pet.badgeText}</span>` : ""}
          </div>
          <div class="pet-info">
            <h3>${pet.name}</h3>
            <p>${pet.breed} | ${pet.age} | ${pet.gender}</p>
            <a href="#" class="btn-outline btn-view" data-pet="${pet.id}">View Profile</a>
            <div class="pet-details" id="pet-${pet.id}">
              <p>${pet.description}</p>
              <ul>
                ${pet.points.map((point) => `<li>${point}</li>`).join("")}
              </ul>
            </div>
          </div>
        </div>
      `,
    )
    .join("");

  // Handle "View Profile" toggle
  const buttons = petGrid.querySelectorAll(".btn-view");
  buttons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const petId = btn.getAttribute("data-pet");
      const details = document.getElementById(`pet-${petId}`);

      document.querySelectorAll(".pet-details").forEach((d) => {
        if (d !== details) d.classList.remove("open");
      });

      if (details) {
        details.classList.toggle("open");
      }
    });
  });
});
