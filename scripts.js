document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll("nav a");
    const profileCards = document.querySelectorAll(".profile");

    navLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: "smooth",
                });
            }
        });
    });

    // Parallax effects para sa bawat profiles
    window.addEventListener("scroll", function () {
        const scrollY = window.scrollY;
        profileCards.forEach((card, index) => {
            const speed = 0.3 + index * 0.1;
            card.style.transform = `translateY(${scrollY * speed}px)`;
        });
    });

    const header = document.querySelector("header");
    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            header.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.1)";
            header.style.background = "#02457a";
        } else {
            header.style.boxShadow = "none";
            header.style.background = "#001b48";
        }
    });
});
