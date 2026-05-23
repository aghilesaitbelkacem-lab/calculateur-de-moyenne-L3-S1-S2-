<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Récupération des données
    $nom = $_GET['Nom'] ?? '';
    $prenom = $_GET['Prenom'] ?? '';
    
    // Conversion en nombres flottants avec vérification
    $GPICntrl = floatval($_GET['NT_cntrlGPI'] ?? 0);
    $GPICC = floatval($_GET['NT_CCGPI'] ?? 0);
    $UPDcntrl = floatval($_GET['NT_cntrlUPD'] ?? 0);
    $UPDCC = floatval($_GET['NT_CCUPD'] ?? 0);
    $OMCcntrl = floatval($_GET['NT_cntrlOMC'] ?? 0);
    $OMCCC = floatval($_GET['NT_CCOMC'] ?? 0);
    $POAcntrl = floatval($_GET['NT_cntrlPOA'] ?? 0);
    $POACC = floatval($_GET['NT_CCPOA'] ?? 0);
    $DAWcntrl = floatval($_GET['NT_cntrlDAW'] ?? 0);
    $DAWCC = floatval($_GET['NT_CCDAW'] ?? 0);
    $EABcntrl = floatval($_GET['NT_cntrlEAB'] ?? 0);
    $EABCC = floatval($_GET['NT_CCEAB'] ?? 0);
    
    // Calcul de la moyenne
    $moyenneG = ($GPICntrl * 0.7 + $GPICC * 0.3) * 3 +
                ($OMCcntrl * 0.7 + $OMCCC * 0.3) * 3 +
                ($UPDcntrl * 0.6 + $UPDCC * 0.4) * 3 +
                ($POAcntrl * 0.6 + $POACC * 0.4) * 3 +
                ($DAWcntrl * 0.6 + $DAWCC * 0.4) * 2 +
                ($EABcntrl * 0.6 + $EABCC * 0.4) * 3;
    
    $moyenneTT = $moyenneG / 17;
    $formatted_moyenne = number_format($moyenneTT, 2);
    
    // Détermination du statut
    $status = $moyenneTT > 10 ? 'success' : 'danger';
    $status_text = $moyenneTT > 10 ? 'Validé' : 'Non validé';
    $message = $moyenneTT > 10 ? 
        "Félicitations $prenom $nom, vous avez validé le semestre S1 !" : 
        "$prenom $nom, vous n'avez pas validé le semestre S1.";
    
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Résultat Moyenne S2</title>
        <style>
            :root {
                --primary: #3a86ff;
                --secondary: #8338ec;
                --success: #06d6a0;
                --danger: #ef476f;
                --light: #f8f9fa;
                --dark: #212529;
                --gray: #6c757d;
                --border: #dee2e6;
                --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                color: var(--dark);
            }
            
            .result-card {
                max-width: 500px;
                width: 100%;
                background: white;
                border-radius: 20px;
                box-shadow: var(--shadow);
                overflow: hidden;
                text-align: center;
            }
            
            .result-header {
                background: linear-gradient(90deg, var(--primary), var(--secondary));
                color: white;
                padding: 30px;
            }
            
            .result-header h1 {
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 8px;
            }
            
            .result-header p {
                opacity: 0.9;
                font-size: 15px;
            }
            
            .result-content {
                padding: 40px 30px;
            }
            
            .student-info {
                font-size: 18px;
                margin-bottom: 30px;
                color: var(--gray);
            }
            
            .moyenne-display {
                font-size: 72px;
                font-weight: 700;
                margin: 30px 0;
                position: relative;
                display: inline-block;
            }
            
            .moyenne-display.success {
                color: var(--success);
            }
            
            .moyenne-display.danger {
                color: var(--danger);
            }
            
            .moyenne-display::after {
                content: "/20";
                font-size: 24px;
                font-weight: 400;
                color: var(--gray);
                position: absolute;
                right: -45px;
                bottom: 20px;
            }
            
            .message {
                font-size: 18px;
                line-height: 1.6;
                margin: 25px 0 35px 0;
                padding: 20px;
                background: var(--light);
                border-radius: 12px;
                border-left: 4px solid var(--{$status});
            }
            
            .action-buttons {
                display: flex;
                gap: 15px;
                justify-content: center;
                margin-top: 30px;
            }
            
            .btn {
                padding: 14px 28px;
                border: none;
                border-radius: 10px;
                font-size: 15px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                min-width: 160px;
            }
            
            .btn-primary {
                background: linear-gradient(90deg, var(--primary), var(--secondary));
                color: white;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(58, 134, 255, 0.2);
            }
            
            .btn-secondary {
                background: white;
                color: var(--gray);
                border: 2px solid var(--border);
            }
            
            .btn-secondary:hover {
                background: var(--light);
                border-color: var(--gray);
            }
            
            .details {
                margin-top: 25px;
                padding-top: 20px;
                border-top: 1px solid var(--border);
                color: var(--gray);
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="result-card">
            <div class="result-header">
                <h1>Résultat du Calcul</h1>
                <p>Semestre S1 - Moyenne Générale</p>
            </div>
            
            <div class="result-content">
                <div class="student-info">
                    Étudiant(e) : <strong>$prenom $nom</strong>
                </div>
                
                <div class="moyenne-display $status">
                    $formatted_moyenne
                </div>

                <div class="message">
                    $message
                </div>
                
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="window.location.href='index.html'">
                        Nouveau calcul
                    </button>
                    <button class="btn btn-secondary" onclick="window.history.back()">
                        Retour
                    </button>
                </div>
                
            </div>
        </div>
    </body>
    </html>
    HTML;
}
?>