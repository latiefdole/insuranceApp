function dropdownSearch() {
    return {
        searchTerm: '',
        users: [],
        open: false,
        selectedUserId: null,

        async searchUsers() {
            if (this.searchTerm.length < 2) {
                this.users = [];
                this.open = false;
                return;
            }

            try {
                let response = await fetch(`/search-users?term=${this.searchTerm}`);
                let data = await response.json();
                this.users = data;
                this.open = true;
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },

        selectUser(user) {
            this.searchTerm = user.DisplayName;
            this.selectedUserId = user.UserId;
            this.open = false;
        }
    }
}
