{{-- resources/views/Frontend/cinemagic.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Cinemagic</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Karla:wght@400;600&display=swap" rel="stylesheet">

<style>
  :root{--bg:#090a0f;--panel:#0f1320;--panel-2:#12172a;--muted:#aeb3c2;--text:#e9ecf4;--accent:#ffea00;--chip:#1d2237;--chip-2:#222842;--brand:#ffe866;--danger:#ff5a5a;--success:#2bd576;--radius:16px;--shadow:0 10px 25px rgba(0,0,0,.35)}
  *{box-sizing:border-box} html,body{height:100%}
  body{margin:0;background:var(--bg);color:var(--text);font:15px/1.55 Karla,system-ui,-apple-system,Segoe UI,Roboto}
  a{color:inherit;text-decoration:none} img{display:block;max-width:100%}
  .nav{position:sticky;top:0;z-index:50;background:linear-gradient(180deg,rgba(0,0,0,.65),rgba(0,0,0,0));backdrop-filter:blur(6px)}
  .nav .row{display:flex;align-items:center;gap:16px;max-width:1200px;margin:auto;padding:14px 18px}
  .logo{display:flex;align-items:center;gap:10px;font-weight:700;letter-spacing:.5px}
  .logo i{width:18px;height:18px;background:var(--brand);transform:rotate(45deg);border-radius:3px;box-shadow:0 0 0 3px #0006 inset}
  .nav a{opacity:.8}.nav a:hover{opacity:1} .grow{flex:1}
  .btn,button{background:var(--accent);color:#1a1a1a;border:0;padding:9px 14px;border-radius:10px;font-weight:700;cursor:pointer}
  .ghost{background:transparent;color:var(--text);border:1px solid #ffffff26}
  .hero{position:relative;min-height:64vh;display:grid;place-items:end center;background:
      linear-gradient(180deg,rgba(9,10,15,0) 0%,rgba(9,10,15,.75) 55%,var(--bg) 100%),
      url("https://images.unsplash.com/photo-1517604931442-7e0c8ed2963f?q=80&w=1600&auto=format&fit=crop") center/cover no-repeat}
  .hero .inner{max-width:1200px;width:100%;padding:40px 20px}
  .badge{display:inline-block;background:#000a;border:1px solid #fff3;border-radius:999px;padding:4px 10px;font-size:12px;letter-spacing:.2px}
  .title{font:700 40px/1.1 Montserrat,system-ui;margin:10px 0 6px}
  .meta{display:flex;gap:14px;flex-wrap:wrap;color:var(--muted)}
  .meta span{display:flex;gap:6px;align-items:center}
  .cta{display:flex;gap:10px;margin-top:16px}
  .wrap{max-width:1200px;margin:auto;padding:28px 20px}
  .section-head{display:flex;align-items:center;justify-content:space-between;margin:8px 0 14px}
  .section-head h2{font:700 22px/1.2 Montserrat;margin:0}
  .tabs{display:flex;gap:14px}
  .tab{background:var(--chip);border:1px solid #ffffff17;border-radius:12px;padding:8px 12px;cursor:pointer}
  .tab.active{background:var(--chip-2);box-shadow:inset 0 0 0 2px #fff2}
  .grid{display:grid;gap:16px;grid-template-columns:repeat(2,1fr)}
  @media (min-width:640px){.grid{grid-template-columns:repeat(3,1fr)}}
  @media (min-width:900px){.grid{grid-template-columns:repeat(6,1fr)}}
  .card{background:var(--panel);border:1px solid #ffffff14;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);transition:transform .2s}
  .card:hover{transform:translateY(-4px)}
  .poster{aspect-ratio:2/3;object-fit:cover;width:100%}
  .card .info{padding:10px}
  .card .name{font-weight:600}
  .card .sub{font-size:12px;color:var(--muted)}
  .reviews{display:grid;gap:16px;grid-template-columns:repeat(1,1fr)}
  @media (min-width:900px){.reviews{grid-template-columns:repeat(3,1fr)}}
  .review{background:var(--panel-2);border:1px solid #ffffff14;border-radius:14px;padding:14px}
  .tag{display:inline-block;padding:4px 8px;border-radius:8px;background:#ffffff10;border:1px solid #ffffff25;font-size:12px}
  .booking{display:grid;grid-template-columns:1.2fr .8fr;gap:22px;background:var(--panel);border:1px solid #ffffff14;border-radius:18px;padding:18px}
  @media (max-width:860px){.booking{grid-template-columns:1fr}}
  .screen{height:8px;border-radius:99px;background:linear-gradient(90deg,#fff6,#fff2);margin:6px 0 18px}
  .seats{display:grid;grid-template-columns:repeat(14,1fr);gap:8px}
  .seat{width:100%;aspect-ratio:1/1;border-radius:6px;display:grid;place-items:center;font-size:11px;background:#141a2a;border:1px solid #ffffff14;color:#fff9;cursor:pointer}
  .seat:hover{outline:2px solid #ffffff33}
  .seat.taken{background:#2a1720;color:#fff6;border-color:#7b2e2e}
  .seat.selected{background:#152a1d;color:#e9ffe9;border-color:#2bd576}
  .legend{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px;color:var(--muted);font-size:13px}
  .dot{width:12px;height:12px;border-radius:4px;margin-right:6px;display:inline-block;border:1px solid #ffffff22}
  .d-free{background:#141a2a}.d-taken{background:#2a1720;border-color:#7b2e2e}.d-sel{background:#152a1d;border-color:#2bd576}
  .panel{background:var(--panel-2);border:1px solid #ffffff14;border-radius:14px;padding:14px}
  .row{display:flex;gap:10px;align-items:center}
  .col{display:flex;flex-direction:column;gap:10px}
  footer{color:#74809a;text-align:center;padding:30px 0}
</style>
</head>
<body>

<header class="nav">
  <div class="row">
    <div class="logo"><i></i> Cinemagic</div>
    <nav class="grow" style="display:flex;gap:16px">
      <a href="#home">Home</a>
      <a href="#review">Reviews</a>
      <a href="#booking">Booking</a>
      <a href="#movies">Movies</a>
    </nav>
    <button class="ghost" id="btnMenu">Menu</button>
    <a href="{{ route('fe.login') }}" class="btn">Sign in</a>
  </div>
</header>

<section id="home" class="hero hero--cinemagic"
  style="
    min-height:92vh;
    display:grid;place-items:end start;
    background:
      radial-gradient(1200px 600px at 70% 45%, rgba(0,0,0,.0) 0%, rgba(0,0,0,.35) 60%, rgba(0,0,0,.75) 100%),
      linear-gradient(180deg, rgba(9,10,15,.1) 0%, rgba(9,10,15,.6) 65%, var(--bg) 100%),
      url('{{ asset('assets/image/banners.jpg') }}') center / cover no-repeat;">
  <div class="hero__inner" style="padding:4rem; max-width:900px; color:#fff;">
    <span class="badge">IMAX • Action • 3h 1m</span>
    <h1 class="title">Oppenheimer</h1>
    <div class="meta">
      <span>⭐ 8.7/10</span>
      <span>R18</span>
      <span>2025 • English</span>
    </div>
    <div class="cta" style="margin-top:1.5rem;">
      <button class="btn">Book Tickets</button>
      <button class="ghost">Watch Trailer</button>
    </div>
  </div>
</section>

<section id="review" class="wrap">
  <div class="section-head">
    <h2>Reviews</h2>
    <div class="tabs">
      <div class="tab active">All</div>
      <div class="tab">Critics</div>
      <div class="tab">Audience</div>
    </div>
  </div>
  <div class="reviews">
    <article class="review"><div class="row"><span class="tag">Story</span><strong>4.5/5</strong></div><p>A tense, meticulously crafted biopic with thunderous sound design and unforgettable performances.</p></article>
    <article class="review"><div class="row"><span class="tag">Director</span><strong>4.8/5</strong></div><p>Nolan’s non-linear storytelling hits hard; the pacing builds pressure like a reactor reaching critical mass.</p></article>
    <article class="review"><div class="row"><span class="tag">Cast</span><strong>4.6/5</strong></div><p>Murphy and Downey Jr. carry the film with precision; supporting roles add texture without clutter.</p></article>
  </div>
</section>

<section id="booking" class="wrap">
  <div class="section-head"><h2>Booking</h2><div></div></div>
  <div class="booking">
    <div>
      <div class="panel">
        <div class="row" style="justify-content:space-between">
          <div class="col"><div style="font-weight:700">Oppenheimer</div><div style="color:var(--muted)">Sat • 7:30 PM • Hall A</div></div>
          <div><span class="tag">R18</span></div>
        </div>
      </div>
      <div class="screen" title="Screen"></div>
      <div id="seatGrid" class="seats"></div>
      <div class="legend"><span><i class="dot d-free"></i>Available</span><span><i class="dot d-taken"></i>Taken</span><span><i class="dot d-sel"></i>Selected</span></div>
    </div>
    <aside class="col">
      <div class="panel">
        <div style="font-weight:700;margin-bottom:10px">Summary</div>
        <div class="row" style="justify-content:space-between"><span>Seats</span><span id="selSeats">—</span></div>
        <div class="row" style="justify-content:space-between"><span>Price</span><span>$<span id="price">0</span></span></div>
        <button style="width:100%;margin-top:10px">Confirm Booking</button>
      </div>
      <div class="panel">
        <div style="font-weight:700;margin-bottom:10px">Showtime</div>
        <div class="row" style="flex-wrap:wrap;gap:8px">
          <span class="tag">12:30</span><span class="tag">15:00</span><span class="tag">17:30</span><span class="tag">19:30</span>
        </div>
      </div>
    </aside>
  </div>
</section>

<section id="movies" class="wrap">
  <div class="section-head"><h2>Trending</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-trending"></div>

  <div class="section-head" style="margin-top:22px"><h2>Upcoming</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-upcoming"></div>

  <div class="section-head" style="margin-top:22px"><h2>Recommended</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-reco"></div>

  <div class="section-head" style="margin-top:22px"><h2>In Theater</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-theater"></div>
</section>

<footer>Thank you for scrolling • Contact: <a href="mailto:cinemagic@example.com">cinemagic@example.com</a></footer>

<script>
const posters = i => `https://picsum.photos/seed/p${i}/400/600`;
const movies = Array.from({length:30}, (_,i)=>({name:['Oppenheimer','Dune: Part Two','Barbarian','Joker','1917','Interstellar','The Batman','Tenet'][i%8],year:2016+(i%9),poster:posters(i+10),sub:['Action','Sci-Fi','Horror','Drama'][i%4]}));

function shelf(id,start,count){
  const w=document.getElementById(id);
  movies.slice(start,start+count).forEach(m=>{
    const el=document.createElement('a');
    el.className='card'; el.href='#';
    el.innerHTML=`<img class="poster" src="${m.poster}" alt="${m.name}">
                  <div class="info"><div class="name">${m.name}</div>
                  <div class="sub">${m.sub} • ${m.year}</div></div>`;
    w.appendChild(el);
  });
}
shelf('grid-trending',0,12);shelf('grid-upcoming',12,12);shelf('grid-reco',4,12);shelf('grid-theater',8,12);

const seatGrid=document.getElementById('seatGrid');const rows=12,cols=14,pricePer=3.5;
const takenSet=new Set(['B5','B6','B7','F9','G9','J2','J3','J4']);const selected=new Set();
for(let r=0;r<rows;r++){
  for(let c=0;c<cols;c++){
    const id=String.fromCharCode(65+r)+(c+1);
    const div=document.createElement('button');
    div.className='seat'+(takenSet.has(id)?' taken':'');
    div.textContent=id;div.title=id;
    if(!takenSet.has(id)){
      div.addEventListener('click',()=>{
        if(selected.has(id)){selected.delete(id);div.classList.remove('selected');}
        else{selected.add(id);div.classList.add('selected');}
        renderSummary();
      });
    }else{div.disabled=true;}
    seatGrid.appendChild(div);
  }
}
function renderSummary(){
  const arr=[...selected].sort();
  document.getElementById('selSeats').textContent=arr.length?arr.join(', '):'—';
  document.getElementById('price').textContent=(arr.length*pricePer).toFixed(2);
}
renderSummary();

document.getElementById('btnMenu').addEventListener('click',()=>{
  alert('Here you can open a slide-out menu with profile, settings, languages, etc.');
});
</script>
</body>
</html>
