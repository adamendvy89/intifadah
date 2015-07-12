/* Configuration your application */
define(function() {

  var QMCONFIG = {

    /* Production environment */
    qbAccount: {
      appId: 25511,
      authKey: '6W2sBCg6hPVXvg7',
      authSecret: '7wn2qJ7kFbDFXfZ'
    },
    fbAccount: {
      appId: '605405446247805',
      scope: 'email,user_friends',
    },

    /* Development environment */
    // qbAccount: {
    //   appId: 14542,
    //   authKey: 'rJqAFphrSnpyZW2',
    //   authSecret: 'tTEB2wK-dU8X3Ra'
    // },
    // fbAccount: {
    //   appId: '605405446247805',
    //   scope: 'email,user_friends',
    // },

    /* Test local environment */
    // qbAccount: {
    //   appId: 14303,
    //   authKey: 'gj5Vps4QB-HKJgt',
    //   authSecret: 'AHpJ6T4L9cVrMxc'
    // },
    // fbAccount: {
    //   appId: '623755094412840',
    //   scope: 'email,user_friends',
    // },

    debug: true,
    isMac: !!navigator.platform.match(/Mac/) ? 1 : 0,

    defAvatar: {
      url: 'images/ava-single.svg',
      group_url: 'images/ava-group.svg',
      caption: 'Choose user picture'
    },

    maxLimitFile: 10,

    patterns: {
      name: "[^><;]{3,50}",
      password: "[A-Za-z0-9`~!@#%&=_<>;:,'" + '\\"' + "\\.\\$\\^\\*\\-\\+\\\\\/\\|\\(\\)\\[\\]\\{\\}\\?]{8,40}"
    },

    errors: {
      session: "The QB application credentials you entered are incorrect",
      invalidName: "Name mustn't contain '<', '>' and ';' characters",
      shortName: "Name must be more than 2 characters",
      bigName: "Name mustn't be more than 50 characters",
      invalidEmail: "Please enter a valid Email address",
      invalidPhone: "Phone mustn't contain letters",
      oldPass: "Old password is incorrect",
      invalidPass: "Password mustn't contain non-Latin characters and spaces",
      shortPass: "Password must be more than 7 characters",
      bigPass: "Password mustn't be more than 40 characters",
      avatarType: "Avatar must be image",
      fileName: "File name mustn't be more than 100 characters",
      fileSize: "File mustn't be more than 10 MB",
      emailExists: "The email has already been taken",
      unauthorized: "The email or password is incorrect",
      notFoundEmail: "The email you entered wasn't found",
      crashFBToken: "Sorry, we noticed that you had logged out from Facebook so we need to recreate your FB token now. Please click the Connect with FB button again",
      FBAccountExists: "This FB user already has an account in the Q-municate. You can't combine two Q-municate users"
    }

  };

  return QMCONFIG;

});
