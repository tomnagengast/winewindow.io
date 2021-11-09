describe('Bottle', function () {

    beforeEach(() => {
        cy.refreshDatabase()

        cy.seed('CypressWineryWithBottleSeeder')
    })

    context('as a winery', () => {

        beforeEach(() => {
            cy.login({email: 'winery@example.com'});
        })

        it('can be viewed', () => {
            cy.visit('/bottles/1')
        })

        it('can be created', () => {
            const vintage = '2020'
            const varietal = 'Super Blend'
            cy.visit('/dashboard').get('#create-bottle').click()

            cy.get('#vintage').type(vintage)
            cy.get('#varietal').type(varietal)
            cy.get('#rating').type('3')
            cy.contains('button', 'Save').click()

            cy.url().should('not.contain', '/bottles/create')
            cy.get('body').should('contain', `${vintage} ${varietal}`)
            cy.visit('dashboard').get('body')
                .should('contain', vintage)
                .should('contain', varietal)
        })

        it('can be updated', () => {
            const varietal = 'Super blend'
            cy.visit('/dashboard').get('.active-bottle').first().click()
            cy.contains('button', 'Edit').click()

            cy.get('#varietal').clear().type(varietal)
            cy.contains('button', 'Save').click()
            cy.get('body').should('contain', varietal)
            cy.visit('dashboard').get('body').should('contain', varietal)
        })

        it.only('can has rich text editing', () => {
            //
        })

        it.skip('does not need a description', () => {
            //
        })

        it('can be deleted', () => {
            cy.visit('/dashboard')
            cy.get('body').should('contain', 'Super blend')
            cy.get('.active-bottle').first().click()
            cy.contains('button', 'Edit').click()
            cy.get('#delete').click()
            cy.url().should('contain', '/dashboard')
            cy.get('body').should('not.contain', 'Super blend')
        })

        it('can not be followed', () => {
            cy.visit('dashboard').get('.active-bottle').first().click()
                .get('body').should('not.contain', 'Follow').should('contain', 'Edit')
            cy.visit('wineries/3').get('.active-bottle').first().click()
                .get('body').should('not.contain', 'Follow').should('not.contain', 'Edit')
        })

    })

    context('as a cellar', () => {

        beforeEach(() => {
            cy.login({email: 'cellar@example.com'});
        })

        it('can be viewed', () => {
            cy.visit('/bottles/1')
                .get('#settings').should('exist')
                .get('#winery').should('not.exist')
        })

        it('can not be created', () => {
            cy.visit('dashboard')
                .get('#create-bottle').should('not.exist')
            cy.visit('wineries/1/bottles/create')
                .url().should('contain', '/dashboard')
        })

        it('can not be edited', () => {
            cy.visit('/bottles/1')
                .get('#edit').should('not.exist')

            cy.visit('bottles/1/edit')
                .url().should('contain', '/dashboard')
        })

        it('can not be deleted', () => {
            cy.visit('/bottles/1')
                .get('#edit').should('not.exist')

            cy.visit('bottles/1/destroy')
                .url().should('contain', '/dashboard')

            cy.visit('/bottles/1')
        })

        it('can be followed and unfollowed', () => {
            cy.visit('dashboard').get('body').should('not.contain', 'Super blend')
            cy.visit('wineries/4').get('.active-bottle').first().click().get('#follow').click()
            cy.visit('dashboard').get('body').should('contain', 'Super blend')
            cy.visit('dashboard').get('.active-bottle').first().click().get('#unfollow').click()
            cy.visit('dashboard').get('body').should('not.contain', 'Super blend')
        })

    })

    context('as a guest', () => {

        it('can be viewed', () => {
            cy.visit('/bottles/1')
        })

        it('can not be edited', () => {
            cy.visit('/bottles/1')
                .get('#edit').should('not.exist')

            cy.visit('bottles/1/edit')
                .url().should('contain', '/login')
        })

        it('can not be followed', () => {
            cy.visit('/bottles/1')
                .get('#follow').should('not.exist')
        })

    })

})
