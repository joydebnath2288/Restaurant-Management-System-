// Simple "settings storage" using localStorage
const STORAGE_KEY = "backupSettings";

const backupEnabledChk = document.getElementById("backupEnabled");
const backupTimeInput = document.getElementById("backupTime");
const encryptChk = document.getElementById("encryptEnabled");
const saveBtn = document.getElementById("saveSettingsBtn");
const runBackupBtn = document.getElementById("runBackupBtn");

const lastBackupEl = document.getElementById("lastBackup");
const nextBackupEl = document.getElementById("nextBackup");
const encryptionStatus = document.getElementById("encryptionStatus");
const msgEl = document.getElementById("settingsMessage");

function loadSettings() {
  fetch('index.php?controller=settings&action=get')
    .then(res => res.json())
    .then(data => {
      if (!data) return;

      backupEnabledChk.checked = data.backupEnabled;
      backupTimeInput.value = data.backupTime;
      encryptChk.checked = data.encrypt;

      if (data.lastBackup) {
        lastBackupEl.textContent = data.lastBackup; // Might need formatting from SQL YYYY-MM-DD
      } else {
        lastBackupEl.textContent = "Never";
      }

      updateStatusText();
    })
    .catch(err => console.error("Error loading settings", err));
}

function saveSettings(showMsg = true) {
  const settings = {
    backupEnabled: backupEnabledChk.checked,
    backupTime: backupTimeInput.value || "02:00",
    encrypt: encryptChk.checked,
    lastBackup: lastBackupEl.textContent === "Never" ? null : lastBackupEl.textContent
  };

  fetch('../controler/api_settings.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(settings)
  })
    .then(res => res.json())
    .then(data => {
      updateStatusText();
      if (showMsg) {
        msgEl.textContent = "Settings saved. System will back up data daily.";
      }
    })
    .catch(err => {
      msgEl.textContent = "Error saving settings.";
    });
}

function updateStatusText() {
  const enabled = backupEnabledChk.checked;
  const time = backupTimeInput.value || "02:00";

  encryptionStatus.textContent = encryptChk.checked ? "Enabled" : "Disabled";

  if (!enabled) {
    nextBackupEl.textContent = "Automatic backup disabled";
  } else {
    nextBackupEl.textContent = `Every day at ${time}`;
  }
}

// Simulate running a backup now
function runBackup() {
  const now = new Date();
  const timestamp = now.toLocaleString();

  lastBackupEl.textContent = timestamp;

  const encryptedText = encryptChk.checked
    ? "Backup completed successfully (data encrypted)."
    : "Backup completed successfully (WARNING: encryption is OFF).";

  msgEl.textContent = encryptedText;

  // Save last-backup time
  saveSettings(false);
}

// Event listeners
saveBtn.addEventListener("click", saveSettings);
runBackupBtn.addEventListener("click", runBackup);
backupEnabledChk.addEventListener("change", () => saveSettings(false));
backupTimeInput.addEventListener("change", () => saveSettings(false));
encryptChk.addEventListener("change", () => saveSettings(false));

// Initialize on load
loadSettings();
