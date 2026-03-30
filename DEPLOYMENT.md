# Deployment — liwacap.com

## Infrastructure

- **Server**: AWS EC2 `i-08cca925292766c90` (`158.252.123.222`)
- **Region**: me-central-1 (UAE)
- **OS**: Ubuntu 24.04 LTS
- **Web server**: Apache 2.4 with Let's Encrypt SSL
- **PHP**: 8.2 (via ondrej/php PPA)
- **CMS**: Craft CMS 5
- **Database**: RDS MySQL 8.0 (`database-1.c9acmucmctpk.me-central-1.rds.amazonaws.com`, database: `liwa_website`)
- **AWS Account**: 252056599010 (`liwa` CLI profile)

## Server Access

No SSH key is configured. Access is via **AWS SSM (Systems Manager)**:

```bash
# Run a command on the server
aws --profile liwa ssm send-command \
  --instance-ids i-08cca925292766c90 \
  --document-name "AWS-RunShellScript" \
  --parameters '{"commands":["your-command-here"]}' \
  --query "Command.CommandId" --output text

# Get the output (wait a few seconds first)
aws --profile liwa ssm get-command-invocation \
  --command-id <COMMAND_ID> \
  --instance-id i-08cca925292766c90 \
  --query "[Status,StandardOutputContent,StandardErrorContent]" \
  --output json
```

For multi-line or complex scripts, base64 encode them to avoid escaping issues:

```bash
SCRIPT='#!/bin/bash
cd /var/www/html
php craft version
' && ENCODED=$(echo "$SCRIPT" | base64)

aws --profile liwa ssm send-command \
  --instance-ids i-08cca925292766c90 \
  --document-name "AWS-RunShellScript" \
  --parameters "{\"commands\":[\"echo $ENCODED | base64 -d | bash\"]}" \
  --query "Command.CommandId" --output text
```

**Important**: SSM runs as root with no `$HOME` set. For git commands, prefix with:
```bash
export HOME=/root
git config --global --add safe.directory /var/www/html
```

For Composer, add:
```bash
export COMPOSER_ALLOW_SUPERUSER=1
export COMPOSER_HOME=/root/.composer
```

## Code Deployment

The server has a git repo at `/var/www/html` with two remotes:

- `neworigin` → `https://github.com/chrisrowe/liwa-marketing.git` (use this one)
- `origin` → `https://github.com/imagino/Liwa-Website.git` (legacy, do not use)

### Steps

1. **Merge and push** your changes to `main` locally
2. **Back up the database** on the server:
   ```bash
   cd /var/www/html
   DB_PASS=$(grep ^DB_PASSWORD .env | head -1 | cut -d= -f2 | tr -d '"')
   mysqldump -h database-1.c9acmucmctpk.me-central-1.rds.amazonaws.com \
     -u admin -p"$DB_PASS" --set-gtid-purged=OFF --single-transaction \
     liwa_website > /tmp/liwa_backup_$(date +%Y%m%d).sql
   ```
3. **Pull the code**:
   ```bash
   cd /var/www/html
   git stash        # stash any local permission changes
   git pull neworigin main
   ```
4. **Install dependencies** (if composer.json changed):
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
5. **Run migrations** (if Craft or plugin updates):
   ```bash
   php craft up
   ```
6. **Clear caches**:
   ```bash
   php craft clear-caches/all
   ```
7. **Fix permissions**:
   ```bash
   chown -R www-data:www-data /var/www/html
   ```

### Frontend Build

Frontend assets are pre-built and committed to the repo (`web/bin/`). There is no need to run a build on the server. If you change CSS or JS locally:

```bash
npm run build    # or ddev npm run build
git add web/bin/
git commit
```

## Database Notes

- The RDS password contains a `$` character — be careful with shell escaping. Use the `grep` + `cut` pattern shown above rather than hardcoding it.
- Craft creates automatic backups before migrations at `storage/backups/`. However, the auto-restore can fail on RDS due to missing `SUPER` privileges. Always take a manual backup before running `php craft up`.

## Rollback

1. Restore the database: import your backup SQL file via `mysql`
2. Revert the code: `git checkout <previous-commit>`
3. Re-run `composer install` if dependencies changed
4. Clear caches: `php craft clear-caches/all`

## Last Deployed

- **Date**: 30 March 2026
- **Commit**: `c3803fc` (Craft 5 migration + asset rebuild)
- **PHP upgraded**: 7.4 → 8.2
