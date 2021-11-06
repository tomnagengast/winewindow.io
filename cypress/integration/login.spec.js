

describe('Login', function () {

    before(() => {

        cy.refreshDatabase().seed('CypressUserSeeder')

    })

    beforeEach(() => {

        cy.visit('/').contains('a', 'Log In').click()

    })

    context('with valid credentials', () => {

        it('allows a user to log in', () => {
            cy.get('#email').type('john@example.com')
            cy.get('#password').type('password')
            cy.contains('button', 'Log in').click()

            cy.url().should('include', '/dashboard')
        })

    })

    context('with invalid credentials', () => {

        // handled by html form
        // enable with inertial form validation on blur
        // it('requires a valid email address')
        // it('requires a password')

        it('requires an existing email and password', () => {
            cy.get('#email').type('foobar@example.com')
            cy.get('#password').type('password')
            cy.contains('button', 'Log in').click()

            cy.contains("These credentials do not match our records.")
                .url().should('include', '/login')
        })

    })

})
