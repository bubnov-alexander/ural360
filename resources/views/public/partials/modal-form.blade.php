<div class="wpcf7">
    <form class="wpcf7-form public-form" action="{{ route('callback.store') }}" method="post">
        @csrf
        <input type="hidden" name="page_url" value="{{ url()->current() }}">
        <p class="public-form__lead">Оставьте контакты, и мы свяжемся с вами для уточнения деталей.</p>
        <p>
            <span class="wpcf7-form-control-wrap" data-name="name">
                <input type="text" name="name" value="" size="40" class="wpcf7-form-control wpcf7-text" autocomplete="name" placeholder="Ваше имя">
            </span>
        </p>
        <p>
            <span class="wpcf7-form-control-wrap" data-name="phone">
                <input type="tel" name="phone" value="" size="40" class="wpcf7-form-control wpcf7-tel" autocomplete="tel" placeholder="Ваш телефон" required>
            </span>
        </p>
        <p>
            <span class="wpcf7-form-control-wrap" data-name="comment">
                <textarea name="comment" cols="40" rows="4" class="wpcf7-form-control wpcf7-textarea" placeholder="Комментарий или вопрос"></textarea>
            </span>
        </p>
        <p>
            <input class="wpcf7-form-control wpcf7-submit btn" type="submit" value="Оставить заявку">
        </p>
    </form>
</div>
