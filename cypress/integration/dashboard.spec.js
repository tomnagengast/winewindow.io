describe('Dashboard', function () {

    context('when not logged in', () => {

        it('redirects to the login page', () => {
            cy.visit('/dashboard').get('body')
                .should('not.contain', 'JohnDoe\'s Team')
                .contains('button', 'Log in')
        })

    })

    context('when logged in', () => {

        context('as a cellar', () => {

            context('with no bottles', () => {

                it('dispays suggested wineries', () => {
                    cy.refreshDatabase()
                    cy.login({email: 'cellar@example.com'})
                        .visit('/dashboard')
                        .get('body').should('contain', 'You\'re not following any bottles yet!')
                })

            })

            context('with bottles', () => {

                beforeEach(() => {
                    cy.refreshDatabase()

                    cy.seed('CypressCellarWithBottleSeeder')
                })

                it('dispays the aging chart', () => {
                    cy.login({email: 'cellar@example.com'})
                        .visit('/dashboard')
                        .get('body').should('contain', 'Varietals')
                })

                it('shows a sort dropdown', () => {
                    cy.login({email: 'cellar@example.com'})
                        .visit('/dashboard')
                        .get('body').should('contain', 'Sort by Winery')
                })

            })

        })

        context('as a winery', () => {

            beforeEach(() => {
                cy.refreshDatabase()
            })

            context('with no bottles', () => {

                it('display instructions on adding a bottle', () => {
                    cy.seed('CypressWineryWithoutBottleSeeder')
                    cy.login({email: 'winery@example.com'})
                        .visit('/dashboard')
                        .get('body')
                        .should('contain', 'You haven\'t added any bottles yet!')
                        .should('not.contain', 'Varietals')
                })

            })

            context('with bottles', () => {

                it('dispays the aging chart without a sort dropdown', () => {
                    cy.seed('CypressWineryWithBottleSeeder')
                    cy.login({email: 'winery@example.com'})
                        .visit('/dashboard')
                        .get('body').should('not.contain', 'Sort by Winery')
                        .should('contain', 'Varietals')
                })

            })

        })

    })

})
