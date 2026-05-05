<div class="club-hero">
    <h1 class="hero-title">Explorer les clubs</h1>
    <form method="get" action="index.php" class="no-margin">
        <input type="hidden" name="page" value="club">
        <label>Choisir un club
            <select name="club" onchange="this.form.submit()" class="club-select">
                <option value="">-- Sélectionner --</option>
                <?php foreach ($clubs as $clubOption): ?>
                    <option value="<?= $clubOption['idClub'] ?>" <?= ($selectedClub ?? null) == $clubOption['idClub'] ? 'selected' : '' ?>>
                        <?= $clubOption['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </form>
</div>

<?php if (!empty($selectedClub) && !empty($activeClub)): ?>
    <?php $club = $activeClub; ?>
    <div class="club-card">
        <h2 class="hero-title"><?= $club['nom'] ?></h2>
        <div class="muted">Ville : <?= $club['ville'] ?> • Stade : <?= $club['stadeNom'] ?? 'N/C' ?> • Fondé en <?= $club['anneeCreation'] ?></div>
    </div>

    <h3 class="section-title">Joueurs</h3>
    <div class="club-grid">
        <?php if (!empty($joueursClub)): ?>
            <?php foreach ($joueursClub as $j): ?>
                <div class="club-card">
                    <strong><?= $j['prenom'] ?> <?= $j['nom'] ?></strong>
                    <div class="muted"><?= $j['poste'] ?> • <?= $j['nationalite'] ?></div>
                    <div class="pill">Né le <?= $j['dateNaissance'] ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="muted">Aucun joueur répertorié.</p>
        <?php endif; ?>
    </div>

    <h3 class="section-title">Staff</h3>
    <div class="club-grid">
        <?php if (!empty($staffClub)): ?>
            <?php foreach ($staffClub as $s): ?>
                <div class="club-card">
                    <strong><?= $s['prenom'] ?> <?= $s['nom'] ?></strong>
                    <div class="muted"><?= $s['specialite'] ?> • <?= $s['nationalite'] ?></div>
                    <div class="pill">Né le <?= $s['dateNaissanceStaff'] ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="muted">Aucun membre du staff répertorié.</p>
        <?php endif; ?>
    </div>

    <h3 class="section-title">Matchs</h3>
    <div class="club-grid">
        <?php if (!empty($matchesClub)): ?>
            <?php foreach ($matchesClub as $match): ?>
                <?php
                    $domNom = '';
                    $extNom = '';
                    if (!empty($oppositions[$match['idMatch']] ?? [])) {
                        foreach ($oppositions[$match['idMatch']] as $opp) {
                            if ($opp['role'] === 'domicile') {
                                $domNom = $opp['clubNom'];
                            } elseif ($opp['role'] === 'exterieur') {
                                $extNom = $opp['clubNom'];
                            }
                        }
                    }
                    $labelTeams = trim($domNom . ' - ' . $extNom, ' -');
                ?>
                <div class="match-card">
                    <div><strong><?= $labelTeams ?: 'Match ' . $match['idMatch'] ?></strong></div>
                    <div class="muted"><?= $match['dateMatch'] ?> à <?= $match['heure'] ?> • <?= $match['stadeNom'] ?? '' ?></div>
                    <div class="score-row">Score : <?= $match['scoreDomicile'] ?> - <?= $match['scoreExterieur'] ?></div>
                    <div class="muted">Arbitre : <?= ($match['arbitreNom'] ?? '') . ' ' . ($match['arbitrePrenom'] ?? '') ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="muted">Aucun match trouvé pour ce club.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="club-card">
        <p>Sélectionnez un club pour afficher ses joueurs, staff et matchs.</p>
    </div>
<?php endif; ?>

<?php if (($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
<hr>
<h3>Administration des clubs</h3>
<form method="post" action="index.php?page=club&action=store">
    <label>Nom du club
        <input type="text" name="nom" required>
    </label>
    <label>Ville
        <input type="text" name="ville" required>
    </label>
    <label>Annee de creation
        <input type="number" name="anneeCreation" min="1800" max="2100" required>
    </label>
    <label>Stade
        <select name="idStade" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($stades as $stade): ?>
                <option value="<?= $stade['idStade'] ?>"><?= $stade['nom'] ?> (<?= $stade['ville'] ?>)</option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Enregistrer</button>
</form>

<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Ville</th>
        <th>Annee</th>
        <th>Stade</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($clubs as $club): ?>
        <tr>
            <td><?= $club['nom'] ?></td>
            <td><?= $club['ville'] ?></td>
            <td><?= $club['anneeCreation'] ?></td>
            <td><?= $club['stadeNom'] ?? '' ?></td>
            <td class="actions">
                <details>
                    <summary>Modifier</summary>
                    <form method="post" action="index.php?page=club&action=update">
                        <input type="hidden" name="idClub" value="<?= $club['idClub'] ?>">
                        <label>Nom
                            <input type="text" name="nom" value="<?= htmlspecialchars($club['nom']) ?>" required>
                        </label>
                        <label>Ville
                            <input type="text" name="ville" value="<?= htmlspecialchars($club['ville']) ?>" required>
                        </label>
                        <label>Annee de creation
                            <input type="number" name="anneeCreation" value="<?= htmlspecialchars($club['anneeCreation']) ?>" min="1800" max="2100" required>
                        </label>
                        <label>Stade
                            <select name="idStade" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($stades as $stade): ?>
                                    <option value="<?= $stade['idStade'] ?>" <?= ($club['idStade'] ?? null) == $stade['idStade'] ? 'selected' : '' ?>><?= $stade['nom'] ?> (<?= $stade['ville'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button type="submit">Sauvegarder</button>
                    </form>
                </details>
                <form method="post" action="index.php?page=club&action=delete" onsubmit="return confirm('Supprimer ce club ?');">
                    <input type="hidden" name="idClub" value="<?= $club['idClub'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

