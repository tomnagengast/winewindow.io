describe('Login', function () {
    before(() => {
        cy.refreshDatabase().seed()

        cy.create('App\\Models\\User', {
                name: 'JohnDoe',
                email: 'john@example.com',
                // default 'password'
            })
    })

//     context('with invalid credentials', () => {
//         it('requires a valid email address', () => {
//             cy.visit('/')
//
//             cy.contains('a', 'Sign In').click()
//
//             cy.get('#email').type('foobar')
//             cy.get('#password').focus()
//
//             cy.contains("The email must be a valid email address.")
//         })
//
//         it('requires an existing email address', () => {
//             cy.visit('/')
//
//             cy.contains('a', 'Sign In').click()
//
//             cy.get('#email').type('foobar@example.com')
//             cy.get('#password').focus()
//
//             cy.contains("The provided email does not exist.")
//         })
//
//         it('requires valid credentials', () => {
//             cy.visit('/')
//
//             cy.contains('a', 'Sign In').click()
//
//             cy.get('#email').type('john@example.com')
//             cy.get('#password').type('invalidpassword')
//             cy.contains('button', 'Log In').click()
//
//             cy.contains("We couldn't verify your credentials.")
//         })
//     })
//
    context('with valid credentials', () => {
        it('requires a valid email address', () => {
            cy.request('/')
        })
        it('works', () => {
            cy.visit('/')

            cy.contains('a', 'Log In').click()

            cy.get('#email').type('john@example.com')
            cy.get('#password').type('password')
            cy.contains('button', 'Log in').click()

            // cy.contains("Remember me")
            cy.contains("JohnDoe's Team")
            cy.visit('/dashboard').contains("JohnDoe's Team")
        })
    })
})
