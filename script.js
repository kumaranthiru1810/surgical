document.addEventListener("DOMContentLoaded", function () {
    let swiper = new Swiper(".swiper-container", {
        slidesPerView: 3, // Default (Desktop)
        spaceBetween: 20,
        loop: true, // Enables infinite scrolling
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 3000, // Auto slide every 3 seconds
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                slidesPerView: 1, // Mobile: 1 slide
            },
            768: {
                slidesPerView: 2, // Tablet: 2 slides
            },
            1025: {
                slidesPerView: 3, // Desktop: 3 slides
            }
        }
    });

    // Function to load more testimonials dynamically
    function loadMoreTestimonials() {
        let newTestimonials = [
            {
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias quae ad voluptates aliquam.",
                name: "Alice Johnson",
                role: "Medical Practitioner",
                image: "./assets/testimonial_image.jpg"
            },
            {
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias quae ad voluptates aliquam.",
                name: "Robert Brown",
                role: "Senior Surgeon",
                image: "./assets/testimonial_image.jpg"
            },
            {
                text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias quae ad voluptates aliquam.",
                name: "Emma Wilson",
                role: "Chief Nurse",
                image: "./assets/testimonial_image.jpg"
            }
        ];

        let testimonialContainer = document.getElementById("testimonial-container");

        newTestimonials.forEach(testimonial => {
            let testimonialHTML = `
                <div class="swiper-slide">
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="testimonial-top">
                            <div class="stars">★★★★★</div>
                            <p class="testimonial-text">${testimonial.text}</p>
                        </div> 
                        <div class="testimonial-author">
                            <img src="${testimonial.image}" alt="${testimonial.name}" class="author-image">
                            <div class="author-info">
                                <h4>${testimonial.name}</h4>
                                <p>${testimonial.role}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            testimonialContainer.innerHTML += testimonialHTML;
        });

        // Update Swiper to recognize new slides
        swiper.update();
    }

    // Load more testimonials on scroll (Optional)
    window.addEventListener("scroll", function () {
        let scrollPosition = window.scrollY + window.innerHeight;
        let sectionBottom = document.querySelector(".testimonial-section").offsetTop + document.querySelector(".testimonial-section").offsetHeight;

        if (scrollPosition >= sectionBottom - 100) {
            loadMoreTestimonials();
        }
    });

    // Initial load
    loadMoreTestimonials();
});

// Sample JSON data
const AbsorbentGauzeproductsData = [
    {
      id: 1,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 2,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 3,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 4,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 5,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
  ];
  
  function createProductCard(product) {
    return `
      <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="product-card">
          <img src="${product.image}" alt="Surgical Product" class="product-image">
          <div class="product-specs">
            <div class="spec-item">
              <span class="label">TPI</span> <span class="colon">:</span> <span class="value">${product.tpi}</span>
            </div>
            <div class="spec-item">
              <span class="label">Width</span> <span class="colon">:</span> <span class="value">${product.width.join(', ')}</span>
            </div>
            <div class="spec-item">
              <span class="label">Length</span> <span class="colon">:</span> <span class="value">${product.length}</span>
            </div>
            <div class="spec-item">
              <span class="label">Sterility</span> <span class="colon">:</span> <span class="value">${product.sterility}</span>
            </div>
          </div>
        </div>
      </div>
    `;
  }
  
  function renderProducts() {
    const container = document.getElementById('AbsorbentGauzeproductContainer');
    const productsHTML = AbsorbentGauzeproductsData.map(product => createProductCard(product)).join('');
    container.innerHTML = productsHTML;
  }
  
  document.addEventListener('DOMContentLoaded', renderProducts);
  
//   Roller Bandage product
// Sample JSON data
const RollerBandageproductData = [
    {
      id: 1,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 2,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 3,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 4,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
    {
      id: 5,
      image: "../assets/product_1.png",
      tpi: "27",
      width: ["90cm", "100cm", "110cm"],
      length: "9m - 36m",
      sterility: "Non-Sterile",
    },
  ];
  
  function RollerBandageproductrenderProducts() {
    const container = document.getElementById('RollerBandageproductContainer');
    const productsHTML = RollerBandageproductData.map(product => createProductCard(product)).join('');
    container.innerHTML = productsHTML;
  }
  
  document.addEventListener('DOMContentLoaded', RollerBandageproductrenderProducts);
  
  document.addEventListener('DOMContentLoaded', function() {
    const helperToggle = document.querySelector('.helper-toggle');
    const helperMenu = document.querySelector('.helper-menu');
    
    helperToggle.addEventListener('click', function() {
        helperMenu.classList.toggle('active');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!helperToggle.contains(event.target) && !helperMenu.contains(event.target)) {
            helperMenu.classList.remove('active');
        }
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const helperMenu = document.querySelector('.helper-widget');
    let lastScrollTop = 200;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        if (currentScroll > lastScrollTop) {
            // Scrolling down - Show the menu
            helperMenu.classList.add('show');
        } else {
            // Scrolling up - Hide the menu
            helperMenu.classList.remove('show');
        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    });
});
document.addEventListener('DOMContentLoaded', () => {
  const helperMenu = document.querySelector('.helper-menu');
  const chatbotBox = document.getElementById('chatbot-box');
  const chatbotClose = document.getElementById('chatbot-close');
  const chatbotInput = document.getElementById('chatbot-input');
  const chatbotSend = document.getElementById('chatbot-send');
  const chatbotContent = document.getElementById('chatbot-content');
  const openChatLink = document.getElementById('open-chat');

  // Open chatbot when "Chat with us" is clicked
  openChatLink.addEventListener('click', (e) => {
      e.preventDefault();
      chatbotBox.classList.remove('hidden');
      helperMenu.classList.remove('active');
  });

  // Close chatbot when close button is clicked
  chatbotClose.addEventListener('click', () => {
      chatbotBox.classList.add('hidden');
  });


  

});


