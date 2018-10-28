锘縡unction check_message() {
                if (window.document.adminlogin.username.value == "") {
                    alert("璇疯緭鍏ョ敤鎴峰悕绉?);
                    document.adminlogin.username.focus();
                    return false;
                }
                if (document.adminlogin.password.value == "") {
                    alert("璇疯緭鍏ュ瘑鐮?);
                    document.adminlogin.password.focus();
                    return false;
                }
                return true;
            }
