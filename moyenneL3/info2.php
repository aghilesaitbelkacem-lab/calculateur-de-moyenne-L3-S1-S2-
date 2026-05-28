<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Récupération des données
    $nom = $_GET['Nom'] ?? '';
    $prenom = $_GET['Prenom'] ?? '';
    
    // Conversion en nombres flottants avec vérification
    $BDACntrl = floatval($_GET['NT_cntrlBDA'] ?? 0);
    $BDACC = floatval($_GET['NT_CCBDA'] ?? 0);
    $MSRCntrl = floatval($_GET['NT_cntrlMSR'] ?? 0);
    $MSRCC = floatval($_GET['NT_CCMSR'] ?? 0);
    $PARCntrl = floatval($_GET['NT_cntrlPAR'] ?? 0); 
    $PFECntrl = floatval($_GET['NT_cntrlPFE'] ?? 0);
    
    // Calcul de la moyenne
    $moyenneG = ($BDACntrl * 0.7 + $BDACC * 0.3) * 1 +
                ($MSRCntrl * 0.7 + $MSRCC * 0.3) * 1 +
                ($PARCntrl * 1) * 1 +
                ($PFECntrl * 1) * 3 ;
    
    $moyenneTT = $moyenneG / 6;
    $formatted_moyenne = number_format($moyenneTT, 2);
    
    // Détermination du statut
    $status = $moyenneTT > 10 ? 'success' : 'danger';
    $status_text = $moyenneTT > 10 ? 'Validé' : 'Non validé';
    $message = $moyenneTT > 10 ? 
        "Félicitations $prenom $nom, vous avez validé le semestre S2 !" :
        "$prenom $nom, vous n'avez pas validé le semestre S2.";
    
?>
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

        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        .result-header h1 { font-size: 24px; font-weight: 600; margin-bottom: 8px; }
        .result-header p  { opacity: 0.9; font-size: 15px; }

        .result-content { padding: 40px 30px; }

        .student-info { font-size: 18px; margin-bottom: 30px; color: var(--gray); }

        .moyenne-display {
            font-size: 72px;
            font-weight: 700;
            margin: 30px 0;
            position: relative;
            display: inline-block;
        }

        .moyenne-display.success { color: var(--success); }
        .moyenne-display.danger  { color: var(--danger); }

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
           border-left: 4px solid <?php echo $border_color; ?>;
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
    </style>
</head>
<body>
    <div class="result-card">
        <div class="result-header">
            <h1>Résultat du Calcul</h1>
            <p>Semestre S2 - Moyenne Générale</p>
        </div>

        <div class="result-content">
            <div class="student-info">
                Étudiant(e) : <strong><?php echo htmlspecialchars($prenom . ' ' . $nom); ?></strong>
            </div>

            <div class="moyenne-display <?php echo $status; ?>">
                <?php echo $formatted_moyenne; ?>
            </div>

            <div class="message">
                <?php echo htmlspecialchars($message); ?>
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
<?php } ?>