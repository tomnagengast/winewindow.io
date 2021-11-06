

describe('Register', function () {

    before(() => {

        cy.refreshDatabase()

    })

    beforeEach(() => {

        cy.visit('/').contains('a', 'Register').click()

    })

    context('with valid credentials', () => {

        it('allows a user to log in', () => {
            cy.get('#name').type('John Doe')
            cy.get('#email').type('john@example.com')
            cy.get('#password').type('password')
            cy.get('#password_confirmation').type('password')
            cy.get('#terms').check()
            cy.get('#key').type('hogcanyonwines')
            cy.contains('button', 'Register').click()

            cy.url().should('include', '/dashboard')
        })

    })

    context('with invalid credentials', () => {

        it('asks the user for a beta key', () => {
            cy.get('#name').type('John Doe')
            cy.get('#email').type('john@example.com')
            cy.get('#password').type('password')
            cy.get('#password_confirmation').type('password')
            cy.get('#terms').check()
            cy.contains('button', 'Register').click()

            cy.url().should('include', '/register')
        })

    })

})
