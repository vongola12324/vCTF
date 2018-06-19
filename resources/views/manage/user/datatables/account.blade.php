<div class="media">
    <figure class="media-left">
        <p class="image is-48x48">
            <img src="{{ Gravatar::src($email) }}" style="border-radius: 50%">
        </p>
    </figure>
    <div class="media-content">
        <div class="content">
            <h3 style="margin-bottom: 0">{{ $name }}</h3>
            <p>{{ $email }}</p>
        </div>
    </div>
</div>
