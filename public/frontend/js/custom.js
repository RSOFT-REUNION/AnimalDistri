(function () {
    "use strict";
    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }
    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all)
        if (selectEl) {
            if (all) {
                selectEl.forEach(e => e.addEventListener(type, listener))
            } else {
                selectEl.addEventListener(type, listener)
            }
        }
    }
    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
    }
    /**
     * Preloader
     */
    let preloader = select('#preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.remove()
        });
    }
    /**
     * Back to top button
     */
    let backtotop = select('.back-to-top')
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add('active')
            } else {
                backtotop.classList.remove('active')
            }
        }
        window.addEventListener('load', toggleBacktotop)
        onscroll(document, toggleBacktotop)
    }
    /**
     * Animation on scroll
     */
    window.addEventListener('load', () => {
        AOS.init({
            duration: 1000,
            easing: "ease-in-out",
            once: true,
            mirror: false
        });
    });
})()

/**
 * Autohide Alert
 */
window.setTimeout(function () {
    $(".top-message").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 3000);
/**
 * AOS init
 */
AOS.init();

/**
 * Product Slider
 */
$(document).ready(function(){
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 100,
        itemMargin: 5,
        asNavFor: '#slider'
    });
    $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel",
        start: function(slider){
            $('body').removeClass('loading');
        }
    });
});

/*** Enable tooltips ***/
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

/*** minus plus input ***/
$(document).ready(function() {
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var min = parseInt($input.attr('min'));
        var step = parseInt($input.attr('step')) || 1; // Default to 1 if step is not specified
        var count = parseInt($input.val()) - step;
        count = count < min ? min : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        var max = parseInt($input.attr('max'));
        var step = parseInt($input.attr('step')) || 1; // Default to 1 if step is not specified
        var count = parseInt($input.val()) + step;
        count = count > max ? max : count;
        $input.val(count);
        $input.change();
        return false;
    });
});

function showAlert() {
    const box = document.getElementById('flashMessage');
    box.innerHTML = `<div class="alert alert-success fade show top-message"><i class="fa-solid fa-check"></i> Le produit a bien été ajouté au panier.</div>`;
    // Cacher automatiquement l'alerte après 3 secondes
    window.setTimeout(function () {
        // Cible uniquement l'alerte spécifique que vous venez de montrer
        const alertBox = box.querySelector('.top-message');
        if (alertBox) {
            $(alertBox).fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }
    }, 2000);

        const nb_produit = document.getElementById('nb_produit');

        fetch('/cart/count-product')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                nb_produit.innerHTML = data.count;
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
}

document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.querySelector('.nav-item.dropdown');
    var dropdownMenu = dropdown.querySelector('.dropdown-menu');

    dropdown.addEventListener('mouseenter', function() {
        dropdownMenu.classList.remove('fade-out');
        dropdownMenu.classList.add('fade-in');
        dropdown.classList.add('hover');
        dropdownMenu.style.display = 'block';
    });

    dropdown.addEventListener('mouseleave', function() {
        dropdownMenu.classList.remove('fade-in');
        dropdownMenu.classList.add('fade-out');
        dropdown.classList.remove('hover');
        setTimeout(function() {
            dropdownMenu.style.display = 'none';
        }, 300); // Matches the animation duration
    });
});

