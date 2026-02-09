<div>

    <style>
        body { 
            background:#f8fafc; 
            font-family:'Segoe UI',sans-serif; 
            color:#2d3748; 
            line-height:1.75; 
        }

        .container { 
            max-width:1200px; 
            margin:auto; 
            padding:0 25px; 
        }

        section { 
            padding:100px 0; 
        }

        .section-title { 
            text-align:center; 
            margin-bottom:60px; 
        }

        .section-title h1 { 
            font-size:2.7rem; 
            color:var(--primary-blue); 
            font-weight:700; 
            margin-bottom:10px; 
        }

        .section-title h1:after {
            content:''; 
            width:90px; 
            height:4px; 
            background:var(--primary-blue); 
            display:block; 
            margin:15px auto 0; 
            border-radius:2px;
        }

        .content-block { 
            max-width:850px; 
            margin:auto; 
            text-align:center; 
            font-size:1.18rem; 
            color:#555; 
        }

        .divider {
            width:160px;
            height:2px;
            background:rgba(0,0,0,0.12);
            margin:80px auto;
        }

        /* Two Column Layout */
        .two-col {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:60px;
            align-items:center;
            max-width:1100px;
            margin:auto;
        }

        .two-col p {
            font-size:1.15rem;
            color:#444;
        }

        .two-col ul {
            padding-left:20px;
            list-style:disc;
        }

        .two-col li {
            margin-bottom:12px;
            color:#444;
        }

        /* Soft Section Background */
        .soft-bg {
            background:linear-gradient(to bottom,#f1f7f3,#ffffff);
        }

        /* Highlighted Quote Block */
        .highlight-box {
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 5px 20px rgba(0,0,0,0.06);
            max-width:850px;
            margin:40px auto 0;
            font-size:1.15rem;
            color:#444;
            text-align:center;
            border-left:5px solid var(--primary-blue);
        }

        /* End Statement */
        .final-line {
            font-size:1.3rem;
            margin-top:30px;
            font-weight:700;
            color:var(--primary-blue);
            text-align:center;
        }

        /* RESPONSIVE */
        @media(max-width:768px){
            .section-title h1 { font-size:2.2rem; }
            section { padding:70px 0; }
            .two-col { grid-template-columns:1fr; }
            .highlight-box { margin-top:20px; }
        }

    </style>


    <!-- HERO TITLE -->
    <section class="soft-bg">
        <div class="container section-title">
            <h1>Science of Health</h1>
            <p style="font-size:1.25rem;color:#555; max-width:750px; margin:auto;">
                Understanding how the body truly works — not how trends describe it.
            </p>
        </div>
    </section>


    <!-- INTRO SECTION -->
    <section class="pb-1">
        <div class="container content-block">
            <p>Health is not built by isolated nutrients or quick solutions. It is the result of complex, well-coordinated biological processes working together every day.</p>

            <p style="margin-top:25px;">At Dr Aulakh Health Sciences, the science of health means understanding how the human body actually functions — at the level of cells, enzymes, hormones, and metabolic pathways — and supporting those processes through informed nutrition.</p>
        </div>
    </section>

    <div class="divider"></div>


    <!-- BEYOND SYMPTOMS SECTION -->
    <section class=" p-1">
        <div class="container section-title">
            <h1 style="font-size:2.2rem;">Beyond Symptoms. Toward Understanding.</h1>
        </div>

        <div class="container two-col">
            <div>
                <p>Many people focus only on visible symptoms.  
                We focus on why the body behaves the way it does.</p>

                <div class="highlight-box">
                    When health is understood, better choices follow naturally.
                </div>
            </div>

            <div>
                <ul>
                    <li>How nutrients participate in energy production</li>
                    <li>How minerals support nerve and muscle function</li>
                    <li>How metabolism adapts to stress, diet, and lifestyle</li>
                    <li>Why deficiencies develop over time, not overnight</li>
                </ul>
            </div>
        </div>
    </section>

    <div class="divider"></div>


    <!-- NUTRITION EXPLAINED SECTION -->
    <section class="soft-bg  p-1">
        <div class="container section-title">
            <h1 style="font-size:2.2rem;">Nutrition, Explained — Not Marketed</h1>
        </div>

        <div class="container two-col">
            <div>
                <p>The supplement industry often simplifies science into claims.  
                We do the opposite.</p>
            </div>

            <div>
                <ul>
                    <li>Translate medical and nutritional science into simple language</li>
                    <li>Clarify confusion around labels and dosages</li>
                    <li>Explain importance of nutrient forms and absorption</li>
                    <li>Help distinguish evidence from marketing</li>
                </ul>

                <p class="final-line">No exaggeration. No fear. Just clarity.</p>
            </div>
        </div>
    </section>

    <div class="divider"></div>


    <!-- CLINICAL THINKING SECTION -->
    <section class=" p-1">
        <div class="container section-title">
            <h1 style="font-size:2.2rem;">Clinical Thinking Meets Everyday Health</h1>
        </div>

        <div class="container two-col">
            <div>
                <p>The science of health applies to real people, real routines, and long-term wellbeing.</p>
            </div>

            <div>
                <ul>
                    <li>Clinical experience</li>
                    <li>Scientific literature</li>
                    <li>Understanding Indian dietary patterns</li>
                    <li>Long-term safety considerations</li>
                </ul>
            </div>
        </div>
    </section>

    <div class="divider"></div>


    <!-- WHY SCIENCE FIRST -->
    <section class="soft-bg  p-4">
        <div class="container section-title">
            <h1 style="font-size:2.2rem;">Why Science Comes First</h1>
        </div>

        <div class="container content-block">
            <p>Supplements should never replace understanding — they should support it.</p>

            <ul style="text-align:left; max-width:750px; margin:30px auto;">
                <li>Education comes before recommendation</li>
                <li>Transparency comes before promotion</li>
                <li>Physiology comes before formulations</li>
            </ul>

            <p class="final-line">Because informed decisions lead to sustainable health.</p>
        </div>
    </section>

    <div class="divider"></div>


    <!-- COMMITMENT SECTION -->
    <section class=" p-1">
        <div class="container section-title">
            <h1 style="font-size:2.2rem;">Our Commitment</h1>
        </div>

        <div class="container content-block">
            <p>To present health science honestly.<br>
               To respect the intelligence of the reader.<br>
               To support the body — not manipulate expectations.</p>

            <p class="final-line">
                This is the Science of Health — clear, responsible, and grounded in understanding.
            </p>
        </div>
    </section>

</div>
