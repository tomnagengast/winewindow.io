describe('Bottle', function () {

    beforeEach(() => {

        cy.refreshDatabase()

    })

    it('can be created', () => {

    })

    it('can be only be created by a winery', () => {

    })

    it.only('can be shown', () => {
        cy.seed('CypressUserWineryBottleSeeder')
        cy.visit('/bottles/1')
    })

    it('can be updated', () => {

    })

    it('can be deleted', () => {

    })

    it('can be followed', () => {

    })

    it('can be unfollowed', () => {

    })

    it('can has rich text editing', () => {

    })

    // notifications should be pest tests
})
