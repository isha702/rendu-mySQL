// ─── VALIDATION CHAMPS ──────────────────────────────────────

function validatePseudo(isSubmit = false) {
    const val = document.getElementById('pseudo').value.trim();
    const input = document.getElementById('pseudo');
    const msg = document.getElementById('pseudoMsg');

    if (val.length === 0) {
        if (isSubmit) setError(input, msg, 'Le pseudo est obligatoire.');
        else setNeutral(input, msg, '');
        return false;
    } else if (val.length < 6) {
        setError(input, msg, 'Le pseudo doit contenir au moins 6 caractères.');
        return false;
    } else {
        setSuccess(input, msg, 'Pseudo valide !');
        return true;
    }
}

function validateEmail(isSubmit = false) {
    const val = document.getElementById('email').value.trim();
    const input = document.getElementById('email');
    const msg = document.getElementById('emailMsg');
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (val.length === 0) {
        if (isSubmit) setError(input, msg, 'L\'email est obligatoire.');
        else setNeutral(input, msg, '');
        return false;
    } else if (!regex.test(val)) {
        setError(input, msg, 'Adresse email invalide.');
        return false;
    } else {
        setSuccess(input, msg, 'Email valide !');
        return true;
    }
}

function validatePassword(isSubmit = false) {
    const val = document.getElementById('password').value;
    const input = document.getElementById('password');
    const msg = document.getElementById('passwordMsg');

    if (val.length === 0) {
        if (isSubmit) setError(input, msg, 'Le mot de passe est obligatoire.');
        else setNeutral(input, msg, '');
        return false;
    } else if (val.length < 8) {
        setError(input, msg, 'Le mot de passe doit contenir au moins 8 caractères.');
        return false;
    } else {
        setSuccess(input, msg, 'Mot de passe valide !');
        const confirm = document.getElementById('confirmPassword').value;
        if (confirm.length > 0) validateConfirm();
        return true;
    }
}

function validateConfirm(isSubmit = false) {
    const pass = document.getElementById('password').value;
    const val = document.getElementById('confirmPassword').value;
    const input = document.getElementById('confirmPassword');
    const msg = document.getElementById('confirmPasswordMsg');

    if (val.length === 0) {
        if (isSubmit) setError(input, msg, 'Veuillez confirmer votre mot de passe.');
        else setNeutral(input, msg, '');
        return false;
    } else if (val !== pass) {
        setError(input, msg, 'Les mots de passe ne correspondent pas.');
        return false;
    } else {
        setSuccess(input, msg, 'Les mots de passe correspondent !');
        return true;
    }
}

function validateMaison() {
    const selected = document.querySelector('input[name="maison"]:checked');
    const msg = document.getElementById('maisonMsg');
    const group = document.querySelector('.radio-group');

    if (!selected) {
        msg.textContent = 'Veuillez choisir une maison.';
        msg.className = 'field-msg error';
        group.classList.add('group-error');
        group.classList.remove('group-success');
        return false;
    } else {
        msg.textContent = 'Maison sélectionnée : ' + selected.value.charAt(0).toUpperCase() + selected.value.slice(1) + ' !';
        msg.className = 'field-msg success';
        group.classList.add('group-success');
        group.classList.remove('group-error');
        return true;
    }
}

function validateInterets() {
    const checked = document.querySelectorAll('input[name="interets[]"]:checked');
    const msg = document.getElementById('interetsMsg');
    const group = document.querySelector('.checkbox-group');

    if (checked.length === 0) {
        msg.textContent = 'Veuillez sélectionner au moins un centre d\'intérêt.';
        msg.className = 'field-msg error';
        group.classList.add('group-error');
        group.classList.remove('group-success');
        return false;
    } else {
        msg.textContent = checked.length + ' intérêt(s) sélectionné(s) !';
        msg.className = 'field-msg success';
        group.classList.add('group-success');
        group.classList.remove('group-error');
        return true;
    }
}

// ─── HELPERS ÉTAT VISUEL ────────────────────────────────────

function setError(input, msg, text) {
    input.className = 'input-error';
    msg.textContent = text;
    msg.className = 'field-msg error';
}

function setSuccess(input, msg, text) {
    input.className = 'input-success';
    msg.textContent = text;
    msg.className = 'field-msg success';
}

function setNeutral(input, msg, text) {
    input.className = '';
    msg.textContent = text;
    msg.className = 'field-msg';
}

// ─── LISTENERS TEMPS RÉEL ───────────────────────────────────

document.getElementById('pseudo').addEventListener('input', () => validatePseudo());
document.getElementById('email').addEventListener('input', () => validateEmail());
document.getElementById('password').addEventListener('input', () => validatePassword());
document.getElementById('confirmPassword').addEventListener('input', () => validateConfirm());

document.querySelectorAll('input[name="maison"]').forEach(radio => {
    radio.addEventListener('change', validateMaison);
});

document.querySelectorAll('input[name="interets[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', validateInterets);
});

// ─── SOUMISSION ─────────────────────────────────────────────

document.getElementById('inscriptionForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const ok1 = validatePseudo(true);
    const ok2 = validateEmail(true);
    const ok3 = validatePassword(true);
    const ok4 = validateConfirm(true);
    const ok5 = validateMaison();
    const ok6 = validateInterets();

    console.log('pseudo:', ok1);
    console.log('email:', ok2);
    console.log('password:', ok3);
    console.log('confirm:', ok4);
    console.log('maison:', ok5);
    console.log('interets:', ok6);

    if (ok1 && ok2 && ok3 && ok4 && ok5 && ok6) {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'inscription';
        hidden.value = '1';
        this.appendChild(hidden);
        this.submit(); // ✅ tout est valide → on envoie vraiment vers inscription.php
    } else {
        const formMsg = document.getElementById('formMsg');
        formMsg.style.display = 'block';
        formMsg.textContent = '❌ Veuillez remplir tous les champs obligatoires.';
        formMsg.className = 'form-msg form-error';
        formMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});