<h1>Matchs de rugby</h1>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="matchRugby">
    <label>Filtrer par date
        <input type="date" name="date" value="<?= htmlspecialchars($selectedDate ?? '') ?>">
    </label>
    <button type="submit">Filtrer</button>
    <?php if ($selectedDate): ?>
        <a href="index.php?page=matchRugby">Réinitialiser</a>
    <?php endif; ?>
</form>

<?php if (($currentUser['droits'] ?? null) === ROLE_STAFF || ($currentUser['droits'] ?? null) === ROLE_ADMIN): ?>
<form method="post" action="index.php?page=matchRugby&action=store">
    <div class="grid">
        <label>Date
            <input type="date" name="dateMatch" required>
        </label>
        <label>Heure
            <input type="time" name="heure" required>
        </label>
        <label>Score domicile
            <input type="number" name="scoreDomicile" min="0" value="0">
        </label>
        <label>Score exterieur
            <input type="number" name="scoreExterieur" min="0" value="0">
        </label>
        <label>Annee
            <input type="text" name="annee" required>
        </label>
        <label>Division
            <input type="text" name="division" required>
        </label>
        <label>Stade
            <select name="idStade" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($stades as $stade): ?>
                    <option value="<?= $stade['idStade'] ?>"><?= $stade['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Arbitre
            <select name="idArbitre" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($arbitres as $arbitre): ?>
                    <option value="<?= $arbitre->idArbitre ?>"><?= $arbitre->nom . ' ' . $arbitre->prenom ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Club domicile
            <select name="clubDomicile" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club['idClub'] ?>"><?= $club['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Club exterieur
            <select name="clubExterieur" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club['idClub'] ?>"><?= $club['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <button type="submit">Programmer le match</button>
</form>
<?php endif; ?>

<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Heure</th>
        <th>Score</th>
        <th>Lieu</th>
        <th>Arbitre</th>
        <th>Clubs</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
<?php foreach ($matches as $match): ?>
        <?php
        $domicileId = null;
        $exterieurId = null;
        if (!empty($oppositions[$match['idMatch']])) {
            foreach ($oppositions[$match['idMatch']] as $opp) {
                if ($opp['role'] === 'domicile') {
                    $domicileId = $opp['idClub'];
                } elseif ($opp['role'] === 'exterieur') {
                    $exterieurId = $opp['idClub'];
                }
            }
        }
        ?>
        <tr>
            <td><?= $match['dateMatch'] ?></td>
            <td><?= $match['heure'] ?></td>
            <td><?= $match['scoreDomicile'] ?> - <?= $match['scoreExterieur'] ?></td>
            <td><?= $match['stadeNom'] ?? '' ?></td>
            <td><?= ($match['arbitreNom'] ?? '') . ' ' . ($match['arbitrePrenom'] ?? '') ?></td>
            <td>
                <?php if (!empty($oppositions[$match['idMatch']])): ?>
                    <?php foreach ($oppositions[$match['idMatch']] as $opp): ?>
                        <?= ucfirst($opp['role']) ?> : <?= $opp['clubNom'] ?><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </td>
            <td class="actions">
                <?php if (in_array($currentUser['droits'] ?? -1, [ROLE_STAFF, ROLE_ADMIN], true)): ?>
                <details>
                    <summary>Modifier</summary>
                    <form method="post" action="index.php?page=matchRugby&action=update">
                        <input type="hidden" name="idMatch" value="<?= $match['idMatch'] ?>">
                        <label>Date
                            <input type="date" name="dateMatch" value="<?= htmlspecialchars($match['dateMatch']) ?>" required>
                        </label>
                        <label>Heure
                            <input type="time" name="heure" value="<?= htmlspecialchars($match['heure']) ?>" required>
                        </label>
                        <label>Score domicile
                            <input type="number" name="scoreDomicile" min="0" value="<?= htmlspecialchars($match['scoreDomicile']) ?>">
                        </label>
                        <label>Score exterieur
                            <input type="number" name="scoreExterieur" min="0" value="<?= htmlspecialchars($match['scoreExterieur']) ?>">
                        </label>
                        <label>Annee
                            <input type="text" name="annee" value="<?= htmlspecialchars($match['annee']) ?>" required>
                        </label>
                        <label>Division
                            <input type="text" name="division" value="<?= htmlspecialchars($match['division']) ?>" required>
                        </label>
                        <label>Stade
                            <select name="idStade" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($stades as $stade): ?>
                                    <option value="<?= $stade['idStade'] ?>" <?= ($match['idStade'] ?? null) == $stade['idStade'] ? 'selected' : '' ?>><?= $stade['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>Arbitre
                            <select name="idArbitre" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($arbitres as $arbitre): ?>
                                    <option value="<?= $arbitre->idArbitre ?>" <?= ($match['idArbitre'] ?? null) == $arbitre->idArbitre ? 'selected' : '' ?>><?= $arbitre->nom . ' ' . $arbitre->prenom ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>Club domicile
                            <select name="clubDomicile" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($clubs as $club): ?>
                                    <option value="<?= $club['idClub'] ?>" <?= ($domicileId ?? null) == $club['idClub'] ? 'selected' : '' ?>><?= $club['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>Club exterieur
                            <select name="clubExterieur" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($clubs as $club): ?>
                                    <option value="<?= $club['idClub'] ?>" <?= ($exterieurId ?? null) == $club['idClub'] ? 'selected' : '' ?>><?= $club['nom'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button type="submit">Sauvegarder</button>
                    </form>
                </details>
                <?php endif; ?>
                <?php if (($currentUser['droits'] ?? null) === ROLE_ARBITRE): ?>
                    <?php if (!empty($currentArbitre)): ?>
                        <form method="post" action="index.php?page=matchRugby&action=update">
                            <input type="hidden" name="idMatch" value="<?= $match['idMatch'] ?>">
                            <input type="hidden" name="idArbitre" value="<?= $currentArbitre->idArbitre ?>">
                            <p>Vous affecter comme arbitre : <?= htmlspecialchars(($currentArbitre->nom ?? '') . ' ' . ($currentArbitre->prenom ?? '')) ?></p>
                            <button type="submit">Mettre a jour l'arbitre</button>
                        </form>
                    <?php else: ?>
                        <p class="error-text">Aucun profil arbitre ne correspond à votre compte (nom/prenom).</p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (in_array($currentUser['droits'] ?? -1, [ROLE_STAFF, ROLE_ADMIN], true)): ?>
                    <form method="post" action="index.php?page=matchRugby&action=delete" onsubmit="return confirm('Supprimer ce match ?');">
                        <input type="hidden" name="idMatch" value="<?= $match['idMatch'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

