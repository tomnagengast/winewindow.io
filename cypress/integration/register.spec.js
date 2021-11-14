describe('Register', function () {

    before(() => {

        cy.refreshDatabase()

    })

    beforeEach(() => {

        cy.visit('/').contains('a', 'Sign Up').click()

    })

    context('with valid credentials', () => {

        it('allows a user to log in', () => {
            cy.contains('button', 'Sign Up with Email').click()
            cy.get('#name').type('John Doe')
            cy.get('#email').type('john@example.com')
            cy.get('#password').type('password')
            cy.get('#password_confirmation').type('password')
            cy.get('#terms').check()
            cy.contains('button', 'Sign Up').click()

            cy.url().should('include', '/dashboard')
        })

    })

})
