# VaultX - Secure File Encryption and Decryption System

VaultX is a secure file encryption and decryption platform built with **Laravel** and **Axios**. It utilizes **AES 256** encryption to ensure your files remain protected. With VaultX, users can encrypt files, share them securely with others (even non-registered users), and decrypt them when needed. Files are handled with the utmost care, leaving no traces after decryption.

## Features

- **OAuth or Manual Authentication:** Users can log in via OAuth or manually sign up and log in.
- **AES 256 Encryption:** Files are encrypted using the industry-standard AES 256 algorithm.
- **Instant Decryption:** Encrypted files can be decrypted and downloaded instantly, leaving no traces on the server.
- **Key Storage:** Secure storage of encryption keys for future decryption.
- **File Sharing:** Share encrypted files with anyone, even users not registered on the platform.

## Usage

### Encrypting Files
1. Log in using OAuth or manual authentication.
2. Upload your file to the encryption panel.
3. Your file will be securely encrypted using **AES 256**.
4. Optionally share the encrypted file with other users.

### Decrypting Files
1. Log in and navigate to your encrypted files.
2. Select the file you want to decrypt.
3. The file will be decrypted and immediately downloaded with no trace left behind.

### Sharing Files
- Encrypted files can be securely shared with others via a unique link.
- Recipients do not need to be registered to decrypt shared files.

## Security

- AES 256 encryption ensures top-notch security for all file handling.
- User authentication can be handled securely via OAuth or manual login.
- No traces of files are left after decryption, ensuring data privacy.

---

Feel free to contribute to VaultX by creating pull requests, opening issues, or providing feedback!
