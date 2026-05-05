<h1>Statistiques de match</h1>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="statistiques">
    <label>Choisir un match
        <select name="match" onchange="this.form.submit()">
            <option value="">-- Choisir --</option>
            <?php foreach ($matches as $match): ?>
                <?php
                $dom = '';
                $ext = '';
                if (!empty($oppositions[$match['idMatch']])) {
                    foreach ($oppositions[$match['idMatch']] as $opp) {
                        if ($opp['role'] === 'domicile') {
                            $dom = $opp['clubNom'] ?? '';
                        } elseif ($opp['role'] === 'exterieur') {
                            $ext = $opp['clubNom'] ?? '';
                        }
                    }
                }
                $labelTeams = trim($dom . ' - ' . $ext, ' -');
                $label = ($labelTeams !== '' ? $labelTeams : 'Match ' . $match['idMatch']) . ' (' . $match['dateMatch'] . ')';
                ?>
                <option value="<?= $match['idMatch'] ?>" <?= ($selectedMatch ?? null) == $match['idMatch'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($label) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
</form>

<?php if (!empty($selectedMatch) && (($currentUser['droits'] ?? null) === ROLE_STAFF || ($currentUser['droits'] ?? null) === ROLE_ADMIN)): ?>
<form method="post" action="index.php?page=statistiques&action=store">
    <div class="grid">
        <input type="hidden" name="idMatch" value="<?= $selectedMatch ?>">
        <label>Joueur
            <select name="idJoueur" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($joueurs as $joueur): ?>
                    <option value="<?= $joueur['idJoueur'] ?>"><?= $joueur['nom'] . ' ' . $joueur['prenom'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Points
            <input type="number" name="points" min="0" value="0">
        </label>
        <label>Essais
            <input type="number" name="essais" min="0" value="0">
        </label>
        <label>Transformations
            <input type="number" name="transformations" min="0" value="0">
        </label>
        <label>Drops
            <input type="number" name="drops" min="0" value="0">
        </label>
        <label>Cartons jaunes
            <input type="number" name="cartonsJaunes" min="0" value="0">
        </label>
        <label>Cartons rouges
            <input type="number" name="cartonsRouges" min="0" value="0">
        </label>
    </div>
    <button type="submit">Enregistrer</button>
</form>
<?php elseif (empty($selectedMatch)): ?>
    <p>Choisissez un match pour consulter les statistiques.</p>
<?php endif; ?>

<?php
// Affiche uniquement le match selectionne si fourni
if (!empty($selectedMatch)) {
    $match = null;
    foreach ($matches as $m) {
        if ((int)$m['idMatch'] === (int)$selectedMatch) {
            $match = $m;
            break;
        }
    }
    if ($match) {
        $dom = '';
        $ext = '';
        if (!empty($oppositions[$match['idMatch']])) {
            foreach ($oppositions[$match['idMatch']] as $opp) {
                if ($opp['role'] === 'domicile') {
                    $dom = $opp['clubNom'] ?? '';
                } elseif ($opp['role'] === 'exterieur') {
                    $ext = $opp['clubNom'] ?? '';
                }
            }
        }
        $titleTeams = trim($dom . ' - ' . $ext, ' -');
        $title = $titleTeams !== '' ? $titleTeams : 'Match #' . $match['idMatch'];
        ?>
        <h2><?= htmlspecialchars($title) ?> - <?= $match['dateMatch'] ?></h2>
        <table>
            <thead>
            <tr>
                <th>Joueur</th>
                <th>Points</th>
                <th>Essais</th>
                <th>Transformations</th>
                <th>Drops</th>
                <th>J</th>
                <th>R</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($statsByMatch[$match['idMatch']] ?? [] as $stat): ?>
                <tr>
                    <td><?= ($stat['joueurNom'] ?? '') . ' ' . ($stat['joueurPrenom'] ?? '') ?></td>
                    <td><?= $stat['points'] ?? 0 ?></td>
                    <td><?= $stat['essais'] ?? 0 ?></td>
                    <td><?= $stat['transformations'] ?? 0 ?></td>
                    <td><?= $stat['drops'] ?? 0 ?></td>
                    <td><?= $stat['cartonsJaunes'] ?? 0 ?></td>
                    <td><?= $stat['cartonsRouges'] ?? 0 ?></td>
                    <td class="actions">
                        <?php if (($currentUser['droits'] ?? null) === ROLE_STAFF || ($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
                        <form method="post" action="index.php?page=statistiques&action=delete" onsubmit="return confirm('Supprimer ces stats ?');">
                            <input type="hidden" name="idJoueur" value="<?= $stat['idJoueur'] ?>">
                            <input type="hidden" name="idMatch" value="<?= $stat['idMatch'] ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php }
}
?>

