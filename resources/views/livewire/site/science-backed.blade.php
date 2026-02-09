<div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9fbfc;
            color: #333;
            line-height: 1.7;
        }

        .container {
            max-width: 1180px;
            margin: auto;
            padding: 0 20px;
        }

        /* Hero Section */
        .hero {
            padding: 90px 0;
            text-align: center;
            background: linear-gradient(to right, #fbfbfb, #eef6f3);
        }

        .hero h1 {
            font-size: 3rem;
            color: var(--primary-blue);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero p {
            max-width: 780px;
            margin: 0 auto 20px;
            color: #555;
            font-size: 1.15rem;
        }

        .tagline {
            max-width: 700px;
            margin: 20px auto 0;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-style: italic;
        }

        /* Section */
        section {
            padding: 80px 0;
        }

        .section-title h2 {
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 50px;
            color: var(--primary-blue);
            position: relative;
        }

        .section-title h2:after {
            content: '';
            width: 80px;
            height: 3px;
            background: var(--primary-blue);
            display: block;
            margin: 10px auto 0;
        }

        /* About Section */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-text p {
            margin-bottom: 18px;
            font-size: 1.08rem;
            color: #444;
        }

        .about-image {
            background: #edf6f9;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .about-image i {
            font-size: 100px;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        /* Difference Section */
        .difference-section {
            background-color: #edf6f9;
        }

        .differences {
            display: grid;
            gap: 35px;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .difference-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
            transition: 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
        }

        .difference-card:hover {
            transform: translateY(-8px);
        }

        .difference-card h3 {
            color: var(--primary-blue);
            font-size: 1.4rem;
            margin-bottom: 12px;
        }

        /* Columns Section */
        .columns {
            display: grid;
            gap: 35px;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .column {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            opacity: 0;
            transform: translateY(20px);
        }

        .column h3 {
            color: var(--primary-blue);
            border-bottom: 2px solid #eef2f3;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .column ul {
            list-style: none;
            padding-left: 0;
        }

        .column li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 12px;
        }

        .column li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary-blue);
            font-weight: bold;
        }

        /* CTA */
        .cta-section {
            background: var(--primary-blue);
            color: white;
            text-align: center;
            padding: 90px 20px;
        }

        .cta-section h2 {
            font-size: 2.4rem;
            margin-bottom: 15px;
        }

        .cta-section p {
            max-width: 700px;
            margin: 0 auto 25px;
            opacity: 0.9;
        }

        .cta-button-large {
            padding: 14px 35px;
            background: white;
            color: var(--primary-blue);
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .cta-button-large:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
        }

        /* Responsive */
        @media(max-width: 768px){
            .hero h1 { font-size: 2.3rem; }
            section { padding: 60px 0; }
            .about-content { grid-template-columns: 1fr; }
        }
    </style>

    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <h1>Science-Backed Supplements</h1>
            <p>Honest formulations, built on clinical understanding — <span class="highlight">not trends.</span></p>
            <p class="tagline">At Dr Aulakh Health Sciences, we believe supplements should be understood before they are used.</p>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section>
        <div class="container about-content">
            <div class="about-text">
                <p>Every formulation begins with human physiology, not marketing claims. Every ingredient is selected for bioavailability, safety, and clarity of purpose.</p>
                <p>We do not believe in overpromising — only in supporting normal body functions through informed nutrition.</p>
            </div>
            <div class="about-image">
                <i class="fas fa-microscope"></i>
                <h3>Science-First Approach</h3>
                <p>Evidence-based formulations grounded in clinical research.</p>
            </div>
        </div>
    </section>

    <!-- DIFFERENCE SECTION -->
    <section class="difference-section">
        <div class="container">
            <div class="section-title"><h2>The Honest Difference</h2></div>

            <div class="differences">
                <div class="difference-card">
                    <h3>What Others Focus On</h3>
                    <p>Most supplements focus on large numbers, flashy claims, and trendy ingredients.</p>
                </div>

                <div class="difference-card">
                    <h3>What We Focus On</h3>
                    <p>We focus on what actually works inside the body:</p>
                    <ul>
                        <li>Clear elemental nutrient declaration</li>
                        <li>Well-absorbed, gentle forms</li>
                        <li>No unnecessary combinations</li>
                        <li>No exaggerated claims</li>
                        <li>No hidden math or shortcuts</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- COLUMNS SECTION -->
    <section>
        <div class="container columns">

            <div class="column">
                <h3>Understanding Nutrition</h3>
                <p>Nutrition supports natural processes, not shortcuts.</p>
                <ul>
                    <li>How nutrients function at the cellular level</li>
                    <li>Why form and dose matter more than numbers</li>
                    <li>Common supplement misunderstandings</li>
                    <li>How to read labels correctly</li>
                </ul>
            </div>

            <div class="column">
                <h3>Doctor's Desk</h3>
                <p>Guided by clinical experience and continuous learning.</p>
                <ul>
                    <li>Evidence-based insights</li>
                    <li>Simple research interpretations</li>
                    <li>Practical nutrition guidance</li>
                    <li>Ingredient safety considerations</li>
                </ul>
            </div>

            <div class="column">
                <h3>Guided Purchase</h3>
                <p>Supplements are not one-size-fits-all.</p>
                <ul>
                    <li>Who a supplement is suitable for</li>
                    <li>How it is commonly used</li>
                    <li>What to expect realistically</li>
                    <li>Quality and safety standards</li>
                </ul>
                <p style="font-weight:600;color:var(--primary-blue);margin-top:10px;">Choose with clarity. Use with confidence.</p>
            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready for Honest Supplements?</h2>
            <p>Explore our science-backed formulations and educational resources.</p>
            <a href="#" class="cta-button-large">Shop Products Now</a>
        </div>
    </section>

    <script>
        const revealElements = document.querySelectorAll('.difference-card, .column');

        const observer = new IntersectionObserver((entries)=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";
                }
            });
        }, {threshold:0.15});

        revealElements.forEach(el=>{
            observer.observe(el);
        });
    </script>

</div>
