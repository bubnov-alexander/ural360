jQuery(document).ready(function ($) {
    console.log("test");

    if ($(window).width() <= "900") {
        //Открытие sub-menu на 900px
        $("#mobile-mnu li.has-childs a").on("click", function (e) {
            console.log("hello");
            if (
                $(e.target).attr("href") == "#" &&
                $(e.target)
                    .closest(".nav-menu-element.has-childs")
                    .hasClass("opened")
            ) {
                $(e.target).siblings(".sub-menu").slideToggle();
                $(e.target)
                    .closest(".nav-menu-element.has-childs")
                    .toggleClass("opened");
            } else if (!$(this).closest("li.has-childs").hasClass("opened")) {
                e.preventDefault();
                $(this).siblings(".sub-menu").slideToggle();
                $(this).closest("li.has-childs").toggleClass("opened");
            }
        });
    }
    $('input[type=tel]').inputmask({"mask": "+7 999 999-99-99"}); //specifying options

    $('input[name=name]').on('input', function(){
       let val = $(this).val();
       let newVal = val;
       let finders = ['0','1','2','3','4','5','6','7','8','9'];
       finders.forEach(function(el,key){
           if(val.includes(el)){
               newVal = val.replace(el, '');
           }
       });

       $(this).val(newVal);
    });

    $('.public-form').on('submit', function (event) {
        event.preventDefault();

        let form = this;
        let submit = form.querySelector('[type="submit"]');
        let formData = new FormData(form);

        if (submit) {
            submit.disabled = true;
        }

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Request failed');
                }

                return response.json();
            })
            .then(function () {
                form.reset();
                document.body.dispatchEvent(new Event('wpcf7mailsent'));
            })
            .catch(function () {
                document.body.dispatchEvent(new Event('wpcf7mailfailed'));
            })
            .finally(function () {
                if (submit) {
                    submit.disabled = false;
                }
            });
    });
    $(document).scroll(function() {
        if ($(this).scrollTop() >= 30) {
        $('#header').addClass('painted');
        // console.log('scroll')
        }else{
        $('#header').removeClass('painted');
        }
    });
    

    // $("li.nav-menu-element a").click(function() { // ID откуда кливаем
    // 	let hash = $(this).attr('href');
    // 	if(hash.length > 1) {
    // 		$(this).parent().addClass('active');
    // 		$(this).parent().siblings().removeClass('active');
    // 		$('html, body').animate({
    //             scrollTop: $(hash).offset().top - 120 // класс объекта к которому приезжаем
    //         }, 1000); // Скорость прокрутки
    // 	}
    // });

    /*============ FUNCTIONS ===========*/

    function callbackViewHook(modal, props) {
        console.log(modal, props);
    }

    let mobileMenu = new MobileMenu(); // Вызов объекта класса мобильного меню
    mobileMenu.init(); // Инициализация мобильного меню
    let themeModal = new ThemeModal(); // Вызов объекта класса модалок

    // themeModal.modalsView['callback'] = {
    // 	callback: callbackViewHook
    // };
    themeModal.init(); // Инициализация модалок

    /*============ ACCARDEON ===========*/

    const contents = $(".accordeon__content");
    const titles = $(".accordeon__title");
    titles.on("click", function () {
        const title = $(this);
        contents.filter(":visible").slideUp(function () {
            $(this).prev(".accordeon__title").removeClass("is-opened");
        });

        const content = title.next(".accordeon__content");

        if (!content.is(":visible")) {
            content.slideDown(function () {
                title.addClass("is-opened");
            });
        }
    });

    contents
        .not(":first")
        .filter(":visible")
        .slideUp(function () {
            $(this).prev(".accordeon__title").removeClass("is-opened");
        });

    jQuery(".accordeon .item__title").on("click", function () {
        jQuery(this).toggleClass("active");
        jQuery(this).siblings(".item__childs").slideToggle();
    });

    /*============ SIDEBARE PRODUCT ===========*/

    $("#open-filter").on("click", function () {
        $(".catalog .sidebar").toggleClass("open");
        $(this).toggleClass("clicked");
    });

    /*============ SINGLE PRODUCT ===========*/

    $(".desc__holder .text").each(function () {
        if ($(this).height() > 24 * 6) {
            console.log(24 * 6);
            $(this).height(24 * 4);
            $(this).css("overflow-y", "hidden");
            $(this).closest(".desc__holder").append('<button type="button" class="desc-all">Читать полностью</button>');
        }
    });
    $("body").on("click", ".desc-all", function () {
        if (!$(this).hasClass("opened")) {
            $(this).closest(".desc__holder").find(".text").css("height", "auto");
            $(this).html("Свернуть");
            $(this).addClass("opened");
        } else {
            $(this).closest(".desc__holder").find(".text").height(24 * 4);
            $(this).html("Смотреть ещё");
            $(this).removeClass("opened");
        }
    });
});
