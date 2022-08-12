# winewindow.io

## Current
- [x] How can I get the bottles for a winery team to show on the dashboard?


Notify followers
- Followed bottle awards
- New releases from followed bottle wineries

Collections
- Event tastings
- Competition entries
- New releases
- Updated tasting notes

## Tests
- As a user, I can create a Winery Team
- As a user, I can create a Cellar Team
- As a user with a Winery, I can create a Bottle for the Winery
- As a user with a Cellar, I can add a Bottle to a Cellar
- As a Bottle Owner, I can Post that the Bottle has won an Award
- As a Bottle Follower, I am notified that the Bottle won an Award
- As a Bottle Owner, I can Post that the Bottle has updated tasting notes/maturity rating
- As a Bottle Follower, I am notified that the Bottle has updated tasting notes/maturity rating
- As a Bottle Owner, I can print out a QR code that links to the Bottle or list of Bottles (tasting line-up)
- As a Bottle Follower, I can open the QR code page and follow the associated Bottles 


## Adding a new server in forge
1. Create new server
2. Delete default site
3. Create new site
4. Add the existing SSL cert from Cloudflare
5. Comment out the SAMEORGIN nginx config
6. Swap the DNS IP in Cloudflare

mysqldump --result-file=/Users/tomnagengast/Downloads/ww___aws-2022_08_12_14_11_09-dump.sql 
 
mysqldump --host=127.0.0.1 --port=3306 --user=forge -pMHyGXXz6v4V453tFedFK --all-databases | aws s3 cp - s3://winewindow.io/database-backups/$(date +%s).sql
