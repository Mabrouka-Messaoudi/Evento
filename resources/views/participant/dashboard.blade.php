@extends('participant.base')

@section('content')

<div class="our_room">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Nos Événements</h2>
                    <p>Découvrez nos événements à venir</p>
                </div>
            </div>
        </div>

        <!-- Filtre par catégorie -->
        <div class="filter-section mb-4">
            <form method="GET" action="{{ route('participant.dashboard') }}">
                <select name="categorie_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Filtrer par catégorie --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ ($selectedCategory == $category->id) ? 'selected' : '' }}>
                            {{ $category->nom }}
                        </option>
                    @endforeach
                </select>
                <noscript><button type="submit">Filtrer</button></noscript>
            </form>
        </div>

        <!-- Liste des événements -->
        <div class="row">
            @if($events->isEmpty())
                <div class="col-md-12">
                    <div class="card p-3">
                        <p>Aucun événement trouvé.</p>
                    </div>
                </div>
            @else
                @foreach ($events as $event)
                    <div class="col-md-4 col-sm-6">
                        <div id="serv_hover" class="room card p-3 mb-4">
                            <p><strong>Titre:</strong> {{ $event->titre }}</p>

                            <div class="room_img mb-3">
                                <figure>
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement" class="img-fluid rounded" />
                                </figure>
                            </div>

                            <p><strong>Description:</strong> {{ $event->description }}</p>
                            <p>
                                <strong>Date début:</strong> {{ \Carbon\Carbon::parse($event->date_debut)->format('d M Y H:i') }}<br>
                                <strong>Date fin:</strong> {{ \Carbon\Carbon::parse($event->date_fin)->format('d M Y H:i') }}
                            </p>
                            <p><strong>Lieu:</strong> {{ $event->lieu }}</p>
                            <p><strong>Capacité:</strong> {{ $event->capacite }}</p>
                            <p><strong>Catégorie:</strong> {{ $event->categorie->nom ?? 'N/A' }}</p>

                            <div class="mt-3">
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-dark mb-2">Voir les détails</a>
                                <form action="{{ route('reservations.store', $event->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-dark">Participer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- ===================== CHATBOT WIDGET ===================== -->
<div id="chatbot-widget">
    <button onclick="toggleChatbot()" class="btn btn-dark" style="position: fixed; bottom: 20px; right: 20px; border-radius: 50%; padding: 15px; z-index:999;">
        💬
    </button>

    <div id="chatbot-box" style="display:none; position: fixed; bottom: 80px; right: 20px; width: 350px; height: 450px; background: white; border: 1px solid #ccc; border-radius: 10px; padding: 10px; z-index:999; box-shadow: 0px 4px 12px rgba(0,0,0,0.2);">
        <div id="chatbot-messages" style="height: 360px; overflow-y:auto; font-size:14px;"></div>
        <input type="text" id="chatbot-input" class="form-control mt-2" placeholder="Écrivez un message..." onkeydown="if(event.key==='Enter'){ sendMessage(); }">
    </div>
</div>

<script>
function toggleChatbot() {
    let box = document.getElementById("chatbot-box");
    box.style.display = (box.style.display === "none") ? "block" : "none";
}

function sendMessage(userMessage = null) {
    let input = document.getElementById("chatbot-input");
    let messages = document.getElementById("chatbot-messages");

    if(userMessage === null) {
        userMessage = input.value.trim();
        if(userMessage === "") return;
    }

    messages.innerHTML += "<div><b>Vous:</b> " + userMessage + "</div>";

    fetch("/chatbot", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({message: userMessage})
    })
    .then(res => res.json())
    .then(data => {
        messages.innerHTML += "<div><b>Bot:</b> " + data.reply.replace(/\n/g, "<br>") + "</div>";

        // Show quick reply buttons for events
        if(data.events && data.events.length > 0){
            data.events.forEach(event => {
                let btn = document.createElement("button");
                btn.innerText = event.titre;
                btn.className = "btn btn-outline-dark btn-sm m-1";
                btn.onclick = () => sendMessage("Je veux participer à " + event.titre);
                messages.appendChild(btn);
            });
        }

        messages.scrollTop = messages.scrollHeight;
    });

    if(userMessage !== null) input.value = "";
}
</script>

@endsection
