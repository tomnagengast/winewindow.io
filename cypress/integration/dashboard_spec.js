describe('Bottle', function () {

    context('when not logged in', () => {

        it('redirects to the login page', () => {
            cy.visit('/dashboard').get('body')
                .should('not.contain', 'JohnDoe\'s Team')
                .contains('button', 'Log in')
        })

    })

    context('when logged in', () => {

        context('as a cellar', () => {

            it('shows a sort dropdown')

            context('with no bottles', () => {
                it('dispays suggested wineries')
            })

            context('with bottles', () => {
                it('dispays the aging chart')
            })

        })

        context('as a winery', () => {

            it('does not show a sort dropdown')

            context('with no bottles', () => {
                it('display instructions on adding a bottle')
            })

            context('with bottles', () => {
                it('dispays the aging chart')
            })

        })

    })

})
