describe('Settings', function () {
    it.skip('can update a users name')
    it.skip('can update a users password')
    it.skip('can add a new team')
    it('can invite a new user to a team', () => {
        cy.refreshDatabase()
        cy.seed('CypressWineryWithoutBottleSeeder')

        cy.login({email: 'winery@example.com'})
        cy.visit('/teams/3')
        cy.get('#email').type('foo@bar.com')
        cy.contains('Button', 'Administrator').click()
        cy.contains('Button', 'Add').click()
        cy.contains('body', 'Added')
        cy.contains('body', 'Pending Cellar Invitations')
        cy.contains('body', 'foo@bar.com')
    })
})
