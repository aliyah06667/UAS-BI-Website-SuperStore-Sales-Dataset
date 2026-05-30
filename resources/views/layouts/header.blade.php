<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Superstore Dashboard</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

@import url('https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Poppins', sans-serif;
    background:
    radial-gradient(circle at top left,#f9d9e4 0%,transparent 30%),
    radial-gradient(circle at bottom right,#f4d0dc 0%,transparent 30%),
    #fff8f8;

    color:#5e4350;
    overflow-x:hidden;
}

/* HEADINGS */

h1,h2,h3,.logo{
    font-family:'EB Garamond', serif;
}

/* NAVBAR */

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:22px 8%;

    background:rgba(255,255,255,0.55);
    backdrop-filter:blur(18px);

    border-bottom:1px solid rgba(255,255,255,0.3);

    position:sticky;
    top:0;
    z-index:1000;

    box-shadow:
    0 10px 30px rgba(192,108,132,.08);
}

.logo{
    color:#8f3f5c;
    font-size:34px;
    font-weight:700;
    letter-spacing:1px;
}

.navbar nav{
    display:flex;
    align-items:center;
}

.navbar nav a{
    text-decoration:none;
    margin:0 16px;
    color:#7a5b66;
    font-size:14px;
    transition:.3s;
    position:relative;
}

.navbar nav a:hover{
    color:#b54e74;
}

.navbar nav a::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-6px;
    width:0%;
    height:2px;
    background:#c06c84;
    transition:.3s;
}

.navbar nav a:hover::after{
    width:100%;
}

.login-btn{
    padding:13px 26px;
    border-radius:999px;

    background:linear-gradient(135deg,#c06c84,#8f3f5c);

    color:white !important;
    font-size:14px;
    text-decoration:none;

    box-shadow:
    0 10px 25px rgba(192,108,132,.35);

    transition:.35s;
}

.login-btn:hover{
    transform:translateY(-3px);
}

/* HERO */

.hero{
    margin:35px 8%;
    min-height:500px;

    border-radius:38px;

    background:
    linear-gradient(rgba(20,10,15,.78), rgba(20,10,15,.70)),
    url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1600&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
    background-blend-mode:multiply;

    display:flex;
    align-items:center;
    padding:70px;

    position:relative;
    overflow:hidden;

    box-shadow:
    0 25px 50px rgba(143,63,92,.18);
}

.hero::before{
    content:'';
    position:absolute;
    width:500px;
    height:500px;

    background:rgba(255,255,255,0.08);

    border-radius:50%;

    top:-180px;
    right:-120px;

    filter:blur(90px);
}

.hero-content{
    width:65%;
    max-width:900px;
    color:white;
    position:relative;
    z-index:2;
}

.hero-content span{
    letter-spacing:4px;
    font-size:12px;
    text-transform:uppercase;
}

.hero-content h1{
    font-size:74px;
    line-height:1.1;
    margin:22px 0;
    font-weight:600;

    max-width:850px;
}

.hero-content p{
    font-size:15px;
    margin-bottom:35px;
    line-height:1.8;
    opacity:.95;
}

.primary-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:17px 38px;

    border-radius:999px;

    background:
    linear-gradient(135deg,#ffffff,#f3dbe4);

    color:#7d324e;

    text-decoration:none;
    font-weight:600;
    letter-spacing:.3px;

    transition:.4s ease;

    box-shadow:
    0 12px 30px rgba(255,255,255,.15);

    backdrop-filter:blur(10px);
}

.primary-btn:hover{
    transform:translateY(-5px) scale(1.02);

    box-shadow:
    0 20px 40px rgba(255,255,255,.25);
}
/* CATEGORY */

.categories{
    margin:60px 8%;

    display:grid;
    grid-template-columns:repeat(6,1fr);

    gap:20px;
}

.category{
    background:rgba(255,255,255,.7);

    backdrop-filter:blur(12px);

    padding:28px 20px;

    border-radius:24px;

    text-align:center;

    box-shadow:
    0 10px 25px rgba(192,108,132,.08);

    border:1px solid rgba(255,255,255,.5);

    transition:.35s ease;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:14px;
}

.category i{
    font-size:28px;
    color:#b54e74;

    transition:.35s ease;
}

.category span{
    font-size:14px;
    font-weight:500;
    color:#6d2944;
}

.category:hover{
    transform:translateY(-6px);

    box-shadow:
    0 18px 35px rgba(192,108,132,.15);
}

.category:hover i{
    transform:scale(1.1);

    color:#8f3f5c;
}


/* PRODUCTS */

.products{
    margin:80px 8%;
}

.title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.title h2{
    font-size:42px;
    color:#7d324e;
}

.title a{
    text-decoration:none;
    color:#b54e74;
    font-size:14px;
}

.product-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:24px;
}

.card{
    background:rgba(255,255,255,.75);

    backdrop-filter:blur(14px);

    border-radius:30px;

    overflow:hidden;

    border:1px solid rgba(255,255,255,.4);

    box-shadow:
    0 10px 30px rgba(192,108,132,.08);

    transition:.4s;
}

.card:hover{
    transform:translateY(-8px);
}

.card img{
    width:100%;
    height:260px;
    object-fit:cover;
}

.card-content{
    padding:22px;
}

.card-content h3{
    font-size:22px;
    margin-bottom:10px;
    color:#6d2944;
}

.card-content p{
    color:#c06c84;
    font-weight:600;
}

/* BANNER */

.banner{
    margin:80px 8%;

    background:
    linear-gradient(135deg,#f6d7e1,#f0bfd0);

    padding:50px;

    border-radius:35px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    box-shadow:
    0 20px 40px rgba(192,108,132,.12);
}

.banner h2{
    font-size:42px;
    color:#7a304d;
}

.banner p{
    margin-top:12px;
    line-height:1.8;
}

.banner button{
    padding:14px 30px;

    border:none;
    border-radius:999px;

    background:linear-gradient(135deg,#c06c84,#8f3f5c);

    color:white;

    cursor:pointer;

    box-shadow:
    0 10px 25px rgba(192,108,132,.2);
}

/* TESTIMONI */

.testimoni{
    margin:100px 8%;
    text-align:center;
}

.testimoni h2{
    margin-bottom:45px;
    font-size:48px;
    color:#7d324e;
}

.testimoni-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:24px;
}

.testi-card{
    background:rgba(255,255,255,.75);

    backdrop-filter:blur(12px);

    padding:35px;

    border-radius:28px;

    box-shadow:
    0 10px 25px rgba(192,108,132,.08);

    border:1px solid rgba(255,255,255,.5);
}

.testi-card p{
    line-height:1.8;
}

.testi-card h4{
    margin-top:18px;
    color:#b54e74;
}


/* FOOTER */

footer{
    margin-top:120px;

    padding:90px 8% 40px;

    background:
    linear-gradient(
        180deg,
        rgba(253,239,242,0.95),
        rgba(248,220,228,0.92)
    );

    backdrop-filter:blur(18px);

    border-top:1px solid rgba(255,255,255,.4);

    position:relative;

    overflow:hidden;
}

/* glow */

footer::before{
    content:'';

    position:absolute;

    width:420px;
    height:420px;

    background:rgba(192,108,132,.12);

    border-radius:50%;

    top:-180px;
    right:-120px;

    filter:blur(50px);
}

.footer-grid{
    position:relative;
    z-index:2;

    display:grid;

    grid-template-columns:
    2.2fr
    1fr
    1fr
    2fr;

    gap:50px;

    align-items:flex-start;
}

footer h3{
    font-size:34px;
    color:#7d324e;
    margin-bottom:18px;
}

footer h4{
    font-size:20px;
    color:#7d324e;
    margin-bottom:20px;
}

footer p{
    font-size:14px;
    line-height:1.9;
    color:#6f5560;
    margin-bottom:12px;
}

.footer-brand p{
    max-width:320px;
}

.footer-links p{
    cursor:pointer;
    transition:.3s;
}

.footer-links p:hover{
    color:#b54e74;
    transform:translateX(3px);
}

/* newsletter */

.newsletter-box{
    background:rgba(255,255,255,.55);

    backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,.5);

    padding:28px;

    border-radius:28px;

    box-shadow:
    0 10px 30px rgba(192,108,132,.08);
}

footer input{
    width:100%;

    padding:15px 18px;

    border:none;

    border-radius:18px;

    margin:18px 0 14px;

    background:white;

    outline:none;

    font-size:14px;

    color:#5e4350;

    box-shadow:
    inset 0 2px 8px rgba(0,0,0,.03);
}

footer input::placeholder{
    color:#b59aa4;
}

footer button{
    width:100%;

    padding:15px;

    border:none;

    border-radius:18px;

    background:
    linear-gradient(135deg,#c06c84,#8f3f5c);

    color:white;

    cursor:pointer;

    font-weight:600;

    transition:.35s;

    box-shadow:
    0 10px 25px rgba(192,108,132,.2);
}

footer button:hover{
    transform:translateY(-3px);
}

/* bottom */

.footer-bottom{
    position:relative;
    z-index:2;

    margin-top:70px;
    padding-top:30px;

    border-top:1px solid rgba(143,63,92,.12);

    display:flex;
    justify-content:space-between;
    align-items:center;

    flex-wrap:wrap;

    gap:20px;
}

.footer-bottom p{
    margin:0;
    font-size:13px;
    color:#8f6b78;
}

.footer-socials{
    display:flex;
    gap:14px;
}

.footer-socials a{
    width:42px;
    height:42px;

    border-radius:50%;

    background:rgba(255,255,255,.7);

    display:flex;
    align-items:center;
    justify-content:center;

    text-decoration:none;

    color:#8f3f5c;

    font-size:15px;

    transition:.3s;
}

.footer-socials a:hover{
    transform:translateY(-4px);

    background:#c06c84;

    color:white;
}

.footer-links a{
    text-decoration:none;
    color:#6f5560;
    transition:.3s;
}

.footer-links a:hover{
    color:#b54e74;
}

.footer-links p{
    margin-bottom:12px;
}

/* RESPONSIVE */

@media(max-width:992px){

    .product-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .categories{
        grid-template-columns:repeat(3,1fr);
    }

    .hero-content{
        width:70%;
    }

}

@media(max-width:768px){

    .hero{
        min-height:auto;
        padding:40px;
    }

    .hero-content{
        width:100%;
    }

    .hero-content h1{
        font-size:48px;
    }

    .categories{
        grid-template-columns:repeat(2,1fr);
    }

    .product-grid{
        grid-template-columns:1fr;
    }

    .testimoni-grid{
        grid-template-columns:1fr;
    }

    .footer-grid{
        grid-template-columns:1fr;
    }

    .navbar nav{
        display:none;
    }

}

</style>

</head>

<body>