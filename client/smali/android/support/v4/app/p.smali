.class Landroid/support/v4/app/p;
.super Ljava/lang/Object;


# annotations
.annotation system Ldalvik/annotation/MemberClasses;
    value = {
        Landroid/support/v4/app/p$a;
    }
.end annotation


# static fields
.field private static final a:[I

.field private static final b:Landroid/support/v4/app/r;

.field private static final c:Landroid/support/v4/app/r;


# direct methods
.method static constructor <clinit>()V
    .locals 2

    const/16 v0, 0xa

    new-array v0, v0, [I

    fill-array-data v0, :array_0

    sput-object v0, Landroid/support/v4/app/p;->a:[I

    sget v0, Landroid/os/Build$VERSION;->SDK_INT:I

    const/16 v1, 0x15

    if-lt v0, v1, :cond_0

    new-instance v0, Landroid/support/v4/app/q;

    invoke-direct {v0}, Landroid/support/v4/app/q;-><init>()V

    :goto_0
    sput-object v0, Landroid/support/v4/app/p;->b:Landroid/support/v4/app/r;

    invoke-static {}, Landroid/support/v4/app/p;->a()Landroid/support/v4/app/r;

    move-result-object v0

    sput-object v0, Landroid/support/v4/app/p;->c:Landroid/support/v4/app/r;

    return-void

    :cond_0
    const/4 v0, 0x0

    goto :goto_0

    nop

    :array_0
    .array-data 4
        0x0
        0x3
        0x0
        0x1
        0x5
        0x4
        0x7
        0x6
        0x9
        0x8
    .end array-data
.end method

.method private static a(Landroid/support/v4/app/p$a;Landroid/util/SparseArray;I)Landroid/support/v4/app/p$a;
    .locals 0
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/p$a;",
            "Landroid/util/SparseArray",
            "<",
            "Landroid/support/v4/app/p$a;",
            ">;I)",
            "Landroid/support/v4/app/p$a;"
        }
    .end annotation

    if-nez p0, :cond_0

    new-instance p0, Landroid/support/v4/app/p$a;

    invoke-direct {p0}, Landroid/support/v4/app/p$a;-><init>()V

    invoke-virtual {p1, p2, p0}, Landroid/util/SparseArray;->put(ILjava/lang/Object;)V

    :cond_0
    return-object p0
.end method

.method private static a()Landroid/support/v4/app/r;
    .locals 2

    :try_start_0
    const-string v0, "android.support.transition.FragmentTransitionSupport"

    invoke-static {v0}, Ljava/lang/Class;->forName(Ljava/lang/String;)Ljava/lang/Class;

    move-result-object v0

    const/4 v1, 0x0

    new-array v1, v1, [Ljava/lang/Class;

    invoke-virtual {v0, v1}, Ljava/lang/Class;->getDeclaredConstructor([Ljava/lang/Class;)Ljava/lang/reflect/Constructor;

    move-result-object v0

    const/4 v1, 0x0

    new-array v1, v1, [Ljava/lang/Object;

    invoke-virtual {v0, v1}, Ljava/lang/reflect/Constructor;->newInstance([Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/support/v4/app/r;
    :try_end_0
    .catch Ljava/lang/Exception; {:try_start_0 .. :try_end_0} :catch_0

    :goto_0
    return-object v0

    :catch_0
    move-exception v0

    const/4 v0, 0x0

    goto :goto_0
.end method

.method private static a(Landroid/support/v4/app/e;Landroid/support/v4/app/e;)Landroid/support/v4/app/r;
    .locals 3

    const/4 v0, 0x0

    new-instance v1, Ljava/util/ArrayList;

    invoke-direct {v1}, Ljava/util/ArrayList;-><init>()V

    if-eqz p0, :cond_2

    invoke-virtual {p0}, Landroid/support/v4/app/e;->y()Ljava/lang/Object;

    move-result-object v2

    if-eqz v2, :cond_0

    invoke-virtual {v1, v2}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    :cond_0
    invoke-virtual {p0}, Landroid/support/v4/app/e;->x()Ljava/lang/Object;

    move-result-object v2

    if-eqz v2, :cond_1

    invoke-virtual {v1, v2}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    :cond_1
    invoke-virtual {p0}, Landroid/support/v4/app/e;->B()Ljava/lang/Object;

    move-result-object v2

    if-eqz v2, :cond_2

    invoke-virtual {v1, v2}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    :cond_2
    if-eqz p1, :cond_5

    invoke-virtual {p1}, Landroid/support/v4/app/e;->w()Ljava/lang/Object;

    move-result-object v2

    if-eqz v2, :cond_3

    invoke-virtual {v1, v2}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    :cond_3
    invoke-virtual {p1}, Landroid/support/v4/app/e;->z()Ljava/lang/Object;

    move-result-object v2

    if-eqz v2, :cond_4

    invoke-virtual {v1, v2}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    :cond_4
    invoke-virtual {p1}, Landroid/support/v4/app/e;->A()Ljava/lang/Object;

    move-result-object v2

    if-eqz v2, :cond_5

    invoke-virtual {v1, v2}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    :cond_5
    invoke-virtual {v1}, Ljava/util/ArrayList;->isEmpty()Z

    move-result v2

    if-eqz v2, :cond_7

    :cond_6
    :goto_0
    return-object v0

    :cond_7
    sget-object v2, Landroid/support/v4/app/p;->b:Landroid/support/v4/app/r;

    if-eqz v2, :cond_8

    sget-object v2, Landroid/support/v4/app/p;->b:Landroid/support/v4/app/r;

    invoke-static {v2, v1}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/util/List;)Z

    move-result v2

    if-eqz v2, :cond_8

    sget-object v0, Landroid/support/v4/app/p;->b:Landroid/support/v4/app/r;

    goto :goto_0

    :cond_8
    sget-object v2, Landroid/support/v4/app/p;->c:Landroid/support/v4/app/r;

    if-eqz v2, :cond_9

    sget-object v2, Landroid/support/v4/app/p;->c:Landroid/support/v4/app/r;

    invoke-static {v2, v1}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/util/List;)Z

    move-result v1

    if-eqz v1, :cond_9

    sget-object v0, Landroid/support/v4/app/p;->c:Landroid/support/v4/app/r;

    goto :goto_0

    :cond_9
    sget-object v1, Landroid/support/v4/app/p;->b:Landroid/support/v4/app/r;

    if-nez v1, :cond_a

    sget-object v1, Landroid/support/v4/app/p;->c:Landroid/support/v4/app/r;

    if-eqz v1, :cond_6

    :cond_a
    new-instance v0, Ljava/lang/IllegalArgumentException;

    const-string v1, "Invalid Transition types"

    invoke-direct {v0, v1}, Ljava/lang/IllegalArgumentException;-><init>(Ljava/lang/String;)V

    throw v0
.end method

.method private static a(ILjava/util/ArrayList;Ljava/util/ArrayList;II)Landroid/support/v4/e/a;
    .locals 9
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(I",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/support/v4/app/b;",
            ">;",
            "Ljava/util/ArrayList",
            "<",
            "Ljava/lang/Boolean;",
            ">;II)",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;"
        }
    .end annotation

    new-instance v7, Landroid/support/v4/e/a;

    invoke-direct {v7}, Landroid/support/v4/e/a;-><init>()V

    add-int/lit8 v0, p4, -0x1

    move v6, v0

    :goto_0
    if-lt v6, p3, :cond_4

    invoke-virtual {p1, v6}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/support/v4/app/b;

    invoke-virtual {v0, p0}, Landroid/support/v4/app/b;->b(I)Z

    move-result v1

    if-nez v1, :cond_1

    :cond_0
    add-int/lit8 v0, v6, -0x1

    move v6, v0

    goto :goto_0

    :cond_1
    invoke-virtual {p2, v6}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v1

    check-cast v1, Ljava/lang/Boolean;

    invoke-virtual {v1}, Ljava/lang/Boolean;->booleanValue()Z

    move-result v1

    iget-object v2, v0, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    if-eqz v2, :cond_0

    iget-object v2, v0, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    invoke-virtual {v2}, Ljava/util/ArrayList;->size()I

    move-result v8

    if-eqz v1, :cond_2

    iget-object v1, v0, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    iget-object v0, v0, Landroid/support/v4/app/b;->s:Ljava/util/ArrayList;

    move-object v3, v1

    move-object v4, v0

    :goto_1
    const/4 v0, 0x0

    move v5, v0

    :goto_2
    if-ge v5, v8, :cond_0

    invoke-virtual {v4, v5}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    invoke-virtual {v3, v5}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v1

    check-cast v1, Ljava/lang/String;

    invoke-virtual {v7, v1}, Landroid/support/v4/e/a;->remove(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v2

    check-cast v2, Ljava/lang/String;

    if-eqz v2, :cond_3

    invoke-virtual {v7, v0, v2}, Landroid/support/v4/e/a;->put(Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    :goto_3
    add-int/lit8 v0, v5, 0x1

    move v5, v0

    goto :goto_2

    :cond_2
    iget-object v1, v0, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    iget-object v0, v0, Landroid/support/v4/app/b;->s:Ljava/util/ArrayList;

    move-object v3, v0

    move-object v4, v1

    goto :goto_1

    :cond_3
    invoke-virtual {v7, v0, v1}, Landroid/support/v4/e/a;->put(Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    goto :goto_3

    :cond_4
    return-object v7
.end method

.method static a(Landroid/support/v4/app/r;Landroid/support/v4/e/a;Ljava/lang/Object;Landroid/support/v4/app/p$a;)Landroid/support/v4/e/a;
    .locals 6
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;",
            "Ljava/lang/Object;",
            "Landroid/support/v4/app/p$a;",
            ")",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Landroid/view/View;",
            ">;"
        }
    .end annotation

    iget-object v0, p3, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    invoke-virtual {v0}, Landroid/support/v4/app/e;->m()Landroid/view/View;

    move-result-object v1

    invoke-virtual {p1}, Landroid/support/v4/e/a;->isEmpty()Z

    move-result v2

    if-nez v2, :cond_0

    if-eqz p2, :cond_0

    if-nez v1, :cond_1

    :cond_0
    invoke-virtual {p1}, Landroid/support/v4/e/a;->clear()V

    const/4 v0, 0x0

    :goto_0
    return-object v0

    :cond_1
    new-instance v2, Landroid/support/v4/e/a;

    invoke-direct {v2}, Landroid/support/v4/e/a;-><init>()V

    invoke-virtual {p0, v2, v1}, Landroid/support/v4/app/r;->a(Ljava/util/Map;Landroid/view/View;)V

    iget-object v3, p3, Landroid/support/v4/app/p$a;->c:Landroid/support/v4/app/b;

    iget-boolean v1, p3, Landroid/support/v4/app/p$a;->b:Z

    if-eqz v1, :cond_4

    invoke-virtual {v0}, Landroid/support/v4/app/e;->U()Landroid/support/v4/app/u;

    move-result-object v1

    iget-object v0, v3, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    move-object v4, v0

    :goto_1
    if-eqz v4, :cond_2

    invoke-virtual {v2, v4}, Landroid/support/v4/e/a;->a(Ljava/util/Collection;)Z

    invoke-virtual {p1}, Landroid/support/v4/e/a;->values()Ljava/util/Collection;

    move-result-object v0

    invoke-virtual {v2, v0}, Landroid/support/v4/e/a;->a(Ljava/util/Collection;)Z

    :cond_2
    if-eqz v1, :cond_6

    invoke-virtual {v1, v4, v2}, Landroid/support/v4/app/u;->a(Ljava/util/List;Ljava/util/Map;)V

    invoke-virtual {v4}, Ljava/util/ArrayList;->size()I

    move-result v0

    add-int/lit8 v0, v0, -0x1

    move v3, v0

    :goto_2
    if-ltz v3, :cond_7

    invoke-virtual {v4, v3}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    invoke-virtual {v2, v0}, Landroid/support/v4/e/a;->get(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v1

    check-cast v1, Landroid/view/View;

    if-nez v1, :cond_5

    invoke-static {p1, v0}, Landroid/support/v4/app/p;->a(Landroid/support/v4/e/a;Ljava/lang/String;)Ljava/lang/String;

    move-result-object v0

    if-eqz v0, :cond_3

    invoke-virtual {p1, v0}, Landroid/support/v4/e/a;->remove(Ljava/lang/Object;)Ljava/lang/Object;

    :cond_3
    :goto_3
    add-int/lit8 v0, v3, -0x1

    move v3, v0

    goto :goto_2

    :cond_4
    invoke-virtual {v0}, Landroid/support/v4/app/e;->T()Landroid/support/v4/app/u;

    move-result-object v1

    iget-object v0, v3, Landroid/support/v4/app/b;->s:Ljava/util/ArrayList;

    move-object v4, v0

    goto :goto_1

    :cond_5
    invoke-static {v1}, Landroid/support/v4/f/t;->i(Landroid/view/View;)Ljava/lang/String;

    move-result-object v5

    invoke-virtual {v0, v5}, Ljava/lang/String;->equals(Ljava/lang/Object;)Z

    move-result v5

    if-nez v5, :cond_3

    invoke-static {p1, v0}, Landroid/support/v4/app/p;->a(Landroid/support/v4/e/a;Ljava/lang/String;)Ljava/lang/String;

    move-result-object v0

    if-eqz v0, :cond_3

    invoke-static {v1}, Landroid/support/v4/f/t;->i(Landroid/view/View;)Ljava/lang/String;

    move-result-object v1

    invoke-virtual {p1, v0, v1}, Landroid/support/v4/e/a;->put(Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    goto :goto_3

    :cond_6
    invoke-static {p1, v2}, Landroid/support/v4/app/p;->a(Landroid/support/v4/e/a;Landroid/support/v4/e/a;)V

    :cond_7
    move-object v0, v2

    goto :goto_0
.end method

.method static a(Landroid/support/v4/e/a;Landroid/support/v4/app/p$a;Ljava/lang/Object;Z)Landroid/view/View;
    .locals 3
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Landroid/view/View;",
            ">;",
            "Landroid/support/v4/app/p$a;",
            "Ljava/lang/Object;",
            "Z)",
            "Landroid/view/View;"
        }
    .end annotation

    const/4 v2, 0x0

    iget-object v0, p1, Landroid/support/v4/app/p$a;->c:Landroid/support/v4/app/b;

    if-eqz p2, :cond_1

    if-eqz p0, :cond_1

    iget-object v1, v0, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    if-eqz v1, :cond_1

    iget-object v1, v0, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    invoke-virtual {v1}, Ljava/util/ArrayList;->isEmpty()Z

    move-result v1

    if-nez v1, :cond_1

    if-eqz p3, :cond_0

    iget-object v0, v0, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    invoke-virtual {v0, v2}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    :goto_0
    invoke-virtual {p0, v0}, Landroid/support/v4/e/a;->get(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/view/View;

    :goto_1
    return-object v0

    :cond_0
    iget-object v0, v0, Landroid/support/v4/app/b;->s:Ljava/util/ArrayList;

    invoke-virtual {v0, v2}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    goto :goto_0

    :cond_1
    const/4 v0, 0x0

    goto :goto_1
.end method

.method private static a(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Landroid/support/v4/app/e;Z)Ljava/lang/Object;
    .locals 1

    if-eqz p1, :cond_0

    if-nez p2, :cond_1

    :cond_0
    const/4 v0, 0x0

    :goto_0
    return-object v0

    :cond_1
    if-eqz p3, :cond_2

    invoke-virtual {p2}, Landroid/support/v4/app/e;->B()Ljava/lang/Object;

    move-result-object v0

    :goto_1
    invoke-virtual {p0, v0}, Landroid/support/v4/app/r;->b(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    invoke-virtual {p0, v0}, Landroid/support/v4/app/r;->c(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    goto :goto_0

    :cond_2
    invoke-virtual {p1}, Landroid/support/v4/app/e;->A()Ljava/lang/Object;

    move-result-object v0

    goto :goto_1
.end method

.method private static a(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Z)Ljava/lang/Object;
    .locals 1

    if-nez p1, :cond_0

    const/4 v0, 0x0

    :goto_0
    return-object v0

    :cond_0
    if-eqz p2, :cond_1

    invoke-virtual {p1}, Landroid/support/v4/app/e;->z()Ljava/lang/Object;

    move-result-object v0

    :goto_1
    invoke-virtual {p0, v0}, Landroid/support/v4/app/r;->b(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    goto :goto_0

    :cond_1
    invoke-virtual {p1}, Landroid/support/v4/app/e;->w()Ljava/lang/Object;

    move-result-object v0

    goto :goto_1
.end method

.method private static a(Landroid/support/v4/app/r;Landroid/view/ViewGroup;Landroid/view/View;Landroid/support/v4/e/a;Landroid/support/v4/app/p$a;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;
    .locals 14
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Landroid/view/ViewGroup;",
            "Landroid/view/View;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;",
            "Landroid/support/v4/app/p$a;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Ljava/lang/Object;",
            "Ljava/lang/Object;",
            ")",
            "Ljava/lang/Object;"
        }
    .end annotation

    move-object/from16 v0, p4

    iget-object v10, v0, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    move-object/from16 v0, p4

    iget-object v12, v0, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    if-eqz v10, :cond_0

    invoke-virtual {v10}, Landroid/support/v4/app/e;->m()Landroid/view/View;

    move-result-object v2

    const/4 v3, 0x0

    invoke-virtual {v2, v3}, Landroid/view/View;->setVisibility(I)V

    :cond_0
    if-eqz v10, :cond_1

    if-nez v12, :cond_2

    :cond_1
    const/4 v3, 0x0

    :goto_0
    return-object v3

    :cond_2
    move-object/from16 v0, p4

    iget-boolean v13, v0, Landroid/support/v4/app/p$a;->b:Z

    invoke-virtual/range {p3 .. p3}, Landroid/support/v4/e/a;->isEmpty()Z

    move-result v2

    if-eqz v2, :cond_5

    const/4 v2, 0x0

    :goto_1
    move-object/from16 v0, p3

    move-object/from16 v1, p4

    invoke-static {p0, v0, v2, v1}, Landroid/support/v4/app/p;->b(Landroid/support/v4/app/r;Landroid/support/v4/e/a;Ljava/lang/Object;Landroid/support/v4/app/p$a;)Landroid/support/v4/e/a;

    move-result-object v5

    move-object/from16 v0, p3

    move-object/from16 v1, p4

    invoke-static {p0, v0, v2, v1}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Landroid/support/v4/e/a;Ljava/lang/Object;Landroid/support/v4/app/p$a;)Landroid/support/v4/e/a;

    move-result-object v8

    invoke-virtual/range {p3 .. p3}, Landroid/support/v4/e/a;->isEmpty()Z

    move-result v3

    if-eqz v3, :cond_6

    const/4 v3, 0x0

    if-eqz v5, :cond_3

    invoke-virtual {v5}, Landroid/support/v4/e/a;->clear()V

    :cond_3
    if-eqz v8, :cond_4

    invoke-virtual {v8}, Landroid/support/v4/e/a;->clear()V

    :cond_4
    :goto_2
    if-nez p7, :cond_7

    if-nez p8, :cond_7

    if-nez v3, :cond_7

    const/4 v3, 0x0

    goto :goto_0

    :cond_5
    invoke-static {p0, v10, v12, v13}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v2

    goto :goto_1

    :cond_6
    invoke-virtual/range {p3 .. p3}, Landroid/support/v4/e/a;->keySet()Ljava/util/Set;

    move-result-object v3

    move-object/from16 v0, p5

    invoke-static {v0, v5, v3}, Landroid/support/v4/app/p;->a(Ljava/util/ArrayList;Landroid/support/v4/e/a;Ljava/util/Collection;)V

    invoke-virtual/range {p3 .. p3}, Landroid/support/v4/e/a;->values()Ljava/util/Collection;

    move-result-object v3

    move-object/from16 v0, p6

    invoke-static {v0, v8, v3}, Landroid/support/v4/app/p;->a(Ljava/util/ArrayList;Landroid/support/v4/e/a;Ljava/util/Collection;)V

    move-object v3, v2

    goto :goto_2

    :cond_7
    const/4 v2, 0x1

    invoke-static {v10, v12, v13, v5, v2}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/e;Landroid/support/v4/app/e;ZLandroid/support/v4/e/a;Z)V

    if-eqz v3, :cond_9

    move-object/from16 v0, p6

    move-object/from16 v1, p2

    invoke-virtual {v0, v1}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    move-object/from16 v0, p2

    move-object/from16 v1, p5

    invoke-virtual {p0, v3, v0, v1}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Landroid/view/View;Ljava/util/ArrayList;)V

    move-object/from16 v0, p4

    iget-boolean v6, v0, Landroid/support/v4/app/p$a;->e:Z

    move-object/from16 v0, p4

    iget-object v7, v0, Landroid/support/v4/app/p$a;->f:Landroid/support/v4/app/b;

    move-object v2, p0

    move-object/from16 v4, p8

    invoke-static/range {v2 .. v7}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Ljava/lang/Object;Landroid/support/v4/e/a;ZLandroid/support/v4/app/b;)V

    new-instance v11, Landroid/graphics/Rect;

    invoke-direct {v11}, Landroid/graphics/Rect;-><init>()V

    move-object/from16 v0, p4

    move-object/from16 v1, p7

    invoke-static {v8, v0, v1, v13}, Landroid/support/v4/app/p;->a(Landroid/support/v4/e/a;Landroid/support/v4/app/p$a;Ljava/lang/Object;Z)Landroid/view/View;

    move-result-object v9

    if-eqz v9, :cond_8

    move-object/from16 v0, p7

    invoke-virtual {p0, v0, v11}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Landroid/graphics/Rect;)V

    :cond_8
    :goto_3
    new-instance v4, Landroid/support/v4/app/p$3;

    move-object v5, v10

    move-object v6, v12

    move v7, v13

    move-object v10, p0

    invoke-direct/range {v4 .. v11}, Landroid/support/v4/app/p$3;-><init>(Landroid/support/v4/app/e;Landroid/support/v4/app/e;ZLandroid/support/v4/e/a;Landroid/view/View;Landroid/support/v4/app/r;Landroid/graphics/Rect;)V

    invoke-static {p1, v4}, Landroid/support/v4/app/t;->a(Landroid/view/View;Ljava/lang/Runnable;)Landroid/support/v4/app/t;

    goto/16 :goto_0

    :cond_9
    const/4 v11, 0x0

    const/4 v9, 0x0

    goto :goto_3
.end method

.method private static a(Landroid/support/v4/app/r;Ljava/lang/Object;Ljava/lang/Object;Ljava/lang/Object;Landroid/support/v4/app/e;Z)Ljava/lang/Object;
    .locals 1

    const/4 v0, 0x1

    if-eqz p1, :cond_0

    if-eqz p2, :cond_0

    if-eqz p4, :cond_0

    if-eqz p5, :cond_1

    invoke-virtual {p4}, Landroid/support/v4/app/e;->D()Z

    move-result v0

    :cond_0
    :goto_0
    if-eqz v0, :cond_2

    invoke-virtual {p0, p2, p1, p3}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    :goto_1
    return-object v0

    :cond_1
    invoke-virtual {p4}, Landroid/support/v4/app/e;->C()Z

    move-result v0

    goto :goto_0

    :cond_2
    invoke-virtual {p0, p2, p1, p3}, Landroid/support/v4/app/r;->b(Ljava/lang/Object;Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    goto :goto_1
.end method

.method private static a(Landroid/support/v4/e/a;Ljava/lang/String;)Ljava/lang/String;
    .locals 3
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;",
            "Ljava/lang/String;",
            ")",
            "Ljava/lang/String;"
        }
    .end annotation

    invoke-virtual {p0}, Landroid/support/v4/e/a;->size()I

    move-result v1

    const/4 v0, 0x0

    :goto_0
    if-ge v0, v1, :cond_1

    invoke-virtual {p0, v0}, Landroid/support/v4/e/a;->c(I)Ljava/lang/Object;

    move-result-object v2

    invoke-virtual {p1, v2}, Ljava/lang/String;->equals(Ljava/lang/Object;)Z

    move-result v2

    if-eqz v2, :cond_0

    invoke-virtual {p0, v0}, Landroid/support/v4/e/a;->b(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    :goto_1
    return-object v0

    :cond_0
    add-int/lit8 v0, v0, 0x1

    goto :goto_0

    :cond_1
    const/4 v0, 0x0

    goto :goto_1
.end method

.method static a(Landroid/support/v4/app/r;Ljava/lang/Object;Landroid/support/v4/app/e;Ljava/util/ArrayList;Landroid/view/View;)Ljava/util/ArrayList;
    .locals 2
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Ljava/lang/Object;",
            "Landroid/support/v4/app/e;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Landroid/view/View;",
            ")",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;"
        }
    .end annotation

    const/4 v0, 0x0

    if-eqz p1, :cond_2

    new-instance v0, Ljava/util/ArrayList;

    invoke-direct {v0}, Ljava/util/ArrayList;-><init>()V

    invoke-virtual {p2}, Landroid/support/v4/app/e;->m()Landroid/view/View;

    move-result-object v1

    if-eqz v1, :cond_0

    invoke-virtual {p0, v0, v1}, Landroid/support/v4/app/r;->a(Ljava/util/ArrayList;Landroid/view/View;)V

    :cond_0
    if-eqz p3, :cond_1

    invoke-virtual {v0, p3}, Ljava/util/ArrayList;->removeAll(Ljava/util/Collection;)Z

    :cond_1
    invoke-virtual {v0}, Ljava/util/ArrayList;->isEmpty()Z

    move-result v1

    if-nez v1, :cond_2

    invoke-virtual {v0, p4}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    invoke-virtual {p0, p1, v0}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Ljava/util/ArrayList;)V

    :cond_2
    return-object v0
.end method

.method private static a(Landroid/support/v4/app/b;Landroid/support/v4/app/b$a;Landroid/util/SparseArray;ZZ)V
    .locals 11
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/b;",
            "Landroid/support/v4/app/b$a;",
            "Landroid/util/SparseArray",
            "<",
            "Landroid/support/v4/app/p$a;",
            ">;ZZ)V"
        }
    .end annotation

    const/4 v10, 0x0

    const/4 v2, 0x1

    const/4 v3, 0x0

    iget-object v1, p1, Landroid/support/v4/app/b$a;->b:Landroid/support/v4/app/e;

    if-nez v1, :cond_1

    :cond_0
    :goto_0
    return-void

    :cond_1
    iget v9, v1, Landroid/support/v4/app/e;->z:I

    if-eqz v9, :cond_0

    if-eqz p3, :cond_5

    sget-object v0, Landroid/support/v4/app/p;->a:[I

    iget v4, p1, Landroid/support/v4/app/b$a;->a:I

    aget v0, v0, v4

    :goto_1
    packed-switch v0, :pswitch_data_0

    :pswitch_0
    move v4, v3

    move v6, v3

    move v7, v3

    move v5, v3

    :goto_2
    invoke-virtual {p2, v9}, Landroid/util/SparseArray;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/support/v4/app/p$a;

    if-eqz v5, :cond_11

    invoke-static {v0, p2, v9}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/p$a;Landroid/util/SparseArray;I)Landroid/support/v4/app/p$a;

    move-result-object v8

    iput-object v1, v8, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    iput-boolean p3, v8, Landroid/support/v4/app/p$a;->b:Z

    iput-object p0, v8, Landroid/support/v4/app/p$a;->c:Landroid/support/v4/app/b;

    :goto_3
    if-nez p4, :cond_3

    if-eqz v4, :cond_3

    if-eqz v8, :cond_2

    iget-object v0, v8, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    if-ne v0, v1, :cond_2

    iput-object v10, v8, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    :cond_2
    iget-object v0, p0, Landroid/support/v4/app/b;->a:Landroid/support/v4/app/k;

    iget v4, v1, Landroid/support/v4/app/e;->b:I

    if-ge v4, v2, :cond_3

    iget v4, v0, Landroid/support/v4/app/k;->l:I

    if-lt v4, v2, :cond_3

    iget-boolean v4, p0, Landroid/support/v4/app/b;->t:Z

    if-nez v4, :cond_3

    invoke-virtual {v0, v1}, Landroid/support/v4/app/k;->f(Landroid/support/v4/app/e;)V

    move v4, v3

    move v5, v3

    invoke-virtual/range {v0 .. v5}, Landroid/support/v4/app/k;->a(Landroid/support/v4/app/e;IIIZ)V

    :cond_3
    if-eqz v6, :cond_10

    if-eqz v8, :cond_4

    iget-object v0, v8, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    if-nez v0, :cond_10

    :cond_4
    invoke-static {v8, p2, v9}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/p$a;Landroid/util/SparseArray;I)Landroid/support/v4/app/p$a;

    move-result-object v0

    iput-object v1, v0, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    iput-boolean p3, v0, Landroid/support/v4/app/p$a;->e:Z

    iput-object p0, v0, Landroid/support/v4/app/p$a;->f:Landroid/support/v4/app/b;

    :goto_4
    if-nez p4, :cond_0

    if-eqz v7, :cond_0

    if-eqz v0, :cond_0

    iget-object v2, v0, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    if-ne v2, v1, :cond_0

    iput-object v10, v0, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    goto :goto_0

    :cond_5
    iget v0, p1, Landroid/support/v4/app/b$a;->a:I

    goto :goto_1

    :pswitch_1
    if-eqz p4, :cond_7

    iget-boolean v0, v1, Landroid/support/v4/app/e;->P:Z

    if-eqz v0, :cond_6

    iget-boolean v0, v1, Landroid/support/v4/app/e;->B:Z

    if-nez v0, :cond_6

    iget-boolean v0, v1, Landroid/support/v4/app/e;->l:Z

    if-eqz v0, :cond_6

    move v0, v2

    :goto_5
    move v4, v2

    move v6, v3

    move v7, v3

    move v5, v0

    goto :goto_2

    :cond_6
    move v0, v3

    goto :goto_5

    :cond_7
    iget-boolean v0, v1, Landroid/support/v4/app/e;->B:Z

    goto :goto_5

    :pswitch_2
    if-eqz p4, :cond_8

    iget-boolean v0, v1, Landroid/support/v4/app/e;->O:Z

    :goto_6
    move v4, v2

    move v6, v3

    move v7, v3

    move v5, v0

    goto :goto_2

    :cond_8
    iget-boolean v0, v1, Landroid/support/v4/app/e;->l:Z

    if-nez v0, :cond_9

    iget-boolean v0, v1, Landroid/support/v4/app/e;->B:Z

    if-nez v0, :cond_9

    move v0, v2

    goto :goto_6

    :cond_9
    move v0, v3

    goto :goto_6

    :pswitch_3
    if-eqz p4, :cond_b

    iget-boolean v0, v1, Landroid/support/v4/app/e;->P:Z

    if-eqz v0, :cond_a

    iget-boolean v0, v1, Landroid/support/v4/app/e;->l:Z

    if-eqz v0, :cond_a

    iget-boolean v0, v1, Landroid/support/v4/app/e;->B:Z

    if-eqz v0, :cond_a

    move v0, v2

    :goto_7
    move v4, v3

    move v6, v0

    move v7, v2

    move v5, v3

    goto/16 :goto_2

    :cond_a
    move v0, v3

    goto :goto_7

    :cond_b
    iget-boolean v0, v1, Landroid/support/v4/app/e;->l:Z

    if-eqz v0, :cond_c

    iget-boolean v0, v1, Landroid/support/v4/app/e;->B:Z

    if-nez v0, :cond_c

    move v0, v2

    goto :goto_7

    :cond_c
    move v0, v3

    goto :goto_7

    :pswitch_4
    if-eqz p4, :cond_e

    iget-boolean v0, v1, Landroid/support/v4/app/e;->l:Z

    if-nez v0, :cond_d

    iget-object v0, v1, Landroid/support/v4/app/e;->J:Landroid/view/View;

    if-eqz v0, :cond_d

    iget-object v0, v1, Landroid/support/v4/app/e;->J:Landroid/view/View;

    invoke-virtual {v0}, Landroid/view/View;->getVisibility()I

    move-result v0

    if-nez v0, :cond_d

    iget v0, v1, Landroid/support/v4/app/e;->Q:F

    const/4 v4, 0x0

    cmpl-float v0, v0, v4

    if-ltz v0, :cond_d

    move v0, v2

    :goto_8
    move v4, v3

    move v6, v0

    move v7, v2

    move v5, v3

    goto/16 :goto_2

    :cond_d
    move v0, v3

    goto :goto_8

    :cond_e
    iget-boolean v0, v1, Landroid/support/v4/app/e;->l:Z

    if-eqz v0, :cond_f

    iget-boolean v0, v1, Landroid/support/v4/app/e;->B:Z

    if-nez v0, :cond_f

    move v0, v2

    goto :goto_8

    :cond_f
    move v0, v3

    goto :goto_8

    :cond_10
    move-object v0, v8

    goto/16 :goto_4

    :cond_11
    move-object v8, v0

    goto/16 :goto_3

    :pswitch_data_0
    .packed-switch 0x1
        :pswitch_2
        :pswitch_0
        :pswitch_4
        :pswitch_3
        :pswitch_1
        :pswitch_4
        :pswitch_2
    .end packed-switch
.end method

.method public static a(Landroid/support/v4/app/b;Landroid/util/SparseArray;Z)V
    .locals 4
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/b;",
            "Landroid/util/SparseArray",
            "<",
            "Landroid/support/v4/app/p$a;",
            ">;Z)V"
        }
    .end annotation

    const/4 v2, 0x0

    iget-object v0, p0, Landroid/support/v4/app/b;->b:Ljava/util/ArrayList;

    invoke-virtual {v0}, Ljava/util/ArrayList;->size()I

    move-result v3

    move v1, v2

    :goto_0
    if-ge v1, v3, :cond_0

    iget-object v0, p0, Landroid/support/v4/app/b;->b:Ljava/util/ArrayList;

    invoke-virtual {v0, v1}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/support/v4/app/b$a;

    invoke-static {p0, v0, p1, v2, p2}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/b;Landroid/support/v4/app/b$a;Landroid/util/SparseArray;ZZ)V

    add-int/lit8 v0, v1, 0x1

    move v1, v0

    goto :goto_0

    :cond_0
    return-void
.end method

.method static a(Landroid/support/v4/app/e;Landroid/support/v4/app/e;ZLandroid/support/v4/e/a;Z)V
    .locals 7
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/e;",
            "Landroid/support/v4/app/e;",
            "Z",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Landroid/view/View;",
            ">;Z)V"
        }
    .end annotation

    const/4 v6, 0x0

    const/4 v1, 0x0

    if-eqz p2, :cond_0

    invoke-virtual {p1}, Landroid/support/v4/app/e;->T()Landroid/support/v4/app/u;

    move-result-object v0

    move-object v2, v0

    :goto_0
    if-eqz v2, :cond_3

    new-instance v3, Ljava/util/ArrayList;

    invoke-direct {v3}, Ljava/util/ArrayList;-><init>()V

    new-instance v4, Ljava/util/ArrayList;

    invoke-direct {v4}, Ljava/util/ArrayList;-><init>()V

    if-nez p3, :cond_1

    move v0, v1

    :goto_1
    if-ge v1, v0, :cond_2

    invoke-virtual {p3, v1}, Landroid/support/v4/e/a;->b(I)Ljava/lang/Object;

    move-result-object v5

    invoke-virtual {v4, v5}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    invoke-virtual {p3, v1}, Landroid/support/v4/e/a;->c(I)Ljava/lang/Object;

    move-result-object v5

    invoke-virtual {v3, v5}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    add-int/lit8 v1, v1, 0x1

    goto :goto_1

    :cond_0
    invoke-virtual {p0}, Landroid/support/v4/app/e;->T()Landroid/support/v4/app/u;

    move-result-object v0

    move-object v2, v0

    goto :goto_0

    :cond_1
    invoke-virtual {p3}, Landroid/support/v4/e/a;->size()I

    move-result v0

    goto :goto_1

    :cond_2
    if-eqz p4, :cond_4

    invoke-virtual {v2, v4, v3, v6}, Landroid/support/v4/app/u;->a(Ljava/util/List;Ljava/util/List;Ljava/util/List;)V

    :cond_3
    :goto_2
    return-void

    :cond_4
    invoke-virtual {v2, v4, v3, v6}, Landroid/support/v4/app/u;->b(Ljava/util/List;Ljava/util/List;Ljava/util/List;)V

    goto :goto_2
.end method

.method private static a(Landroid/support/v4/app/k;ILandroid/support/v4/app/p$a;Landroid/view/View;Landroid/support/v4/e/a;)V
    .locals 23
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/k;",
            "I",
            "Landroid/support/v4/app/p$a;",
            "Landroid/view/View;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;)V"
        }
    .end annotation

    const/4 v3, 0x0

    move-object/from16 v0, p0

    iget-object v2, v0, Landroid/support/v4/app/k;->n:Landroid/support/v4/app/g;

    invoke-virtual {v2}, Landroid/support/v4/app/g;->a()Z

    move-result v2

    if-eqz v2, :cond_0

    move-object/from16 v0, p0

    iget-object v2, v0, Landroid/support/v4/app/k;->n:Landroid/support/v4/app/g;

    move/from16 v0, p1

    invoke-virtual {v2, v0}, Landroid/support/v4/app/g;->a(I)Landroid/view/View;

    move-result-object v2

    check-cast v2, Landroid/view/ViewGroup;

    move-object v3, v2

    :cond_0
    if-nez v3, :cond_2

    :cond_1
    :goto_0
    return-void

    :cond_2
    move-object/from16 v0, p2

    iget-object v15, v0, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    move-object/from16 v0, p2

    iget-object v0, v0, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    move-object/from16 v17, v0

    move-object/from16 v0, v17

    invoke-static {v0, v15}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/e;Landroid/support/v4/app/e;)Landroid/support/v4/app/r;

    move-result-object v2

    if-eqz v2, :cond_1

    move-object/from16 v0, p2

    iget-boolean v0, v0, Landroid/support/v4/app/p$a;->b:Z

    move/from16 v16, v0

    move-object/from16 v0, p2

    iget-boolean v4, v0, Landroid/support/v4/app/p$a;->e:Z

    new-instance v8, Ljava/util/ArrayList;

    invoke-direct {v8}, Ljava/util/ArrayList;-><init>()V

    new-instance v7, Ljava/util/ArrayList;

    invoke-direct {v7}, Ljava/util/ArrayList;-><init>()V

    move/from16 v0, v16

    invoke-static {v2, v15, v0}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v9

    move-object/from16 v0, v17

    invoke-static {v2, v0, v4}, Landroid/support/v4/app/p;->b(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v10

    move-object/from16 v4, p3

    move-object/from16 v5, p4

    move-object/from16 v6, p2

    invoke-static/range {v2 .. v10}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Landroid/view/ViewGroup;Landroid/view/View;Landroid/support/v4/e/a;Landroid/support/v4/app/p$a;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v14

    if-nez v9, :cond_3

    if-nez v14, :cond_3

    if-eqz v10, :cond_1

    :cond_3
    move-object/from16 v0, v17

    move-object/from16 v1, p3

    invoke-static {v2, v10, v0, v7, v1}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Landroid/support/v4/app/e;Ljava/util/ArrayList;Landroid/view/View;)Ljava/util/ArrayList;

    move-result-object v20

    move-object/from16 v0, p3

    invoke-static {v2, v9, v15, v8, v0}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Landroid/support/v4/app/e;Ljava/util/ArrayList;Landroid/view/View;)Ljava/util/ArrayList;

    move-result-object v18

    const/4 v4, 0x4

    move-object/from16 v0, v18

    invoke-static {v0, v4}, Landroid/support/v4/app/p;->a(Ljava/util/ArrayList;I)V

    move-object v11, v2

    move-object v12, v9

    move-object v13, v10

    invoke-static/range {v11 .. v16}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Ljava/lang/Object;Ljava/lang/Object;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v16

    if-eqz v16, :cond_1

    move-object/from16 v0, v17

    move-object/from16 v1, v20

    invoke-static {v2, v10, v0, v1}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Landroid/support/v4/app/e;Ljava/util/ArrayList;)V

    invoke-virtual {v2, v8}, Landroid/support/v4/app/r;->a(Ljava/util/ArrayList;)Ljava/util/ArrayList;

    move-result-object v4

    move-object v15, v2

    move-object/from16 v17, v9

    move-object/from16 v19, v10

    move-object/from16 v21, v14

    move-object/from16 v22, v8

    invoke-virtual/range {v15 .. v22}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Ljava/lang/Object;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;)V

    move-object/from16 v0, v16

    invoke-virtual {v2, v3, v0}, Landroid/support/v4/app/r;->a(Landroid/view/ViewGroup;Ljava/lang/Object;)V

    move-object v5, v2

    move-object v6, v3

    move-object v9, v4

    move-object/from16 v10, p4

    invoke-virtual/range {v5 .. v10}, Landroid/support/v4/app/r;->a(Landroid/view/View;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/util/Map;)V

    const/4 v3, 0x0

    move-object/from16 v0, v18

    invoke-static {v0, v3}, Landroid/support/v4/app/p;->a(Ljava/util/ArrayList;I)V

    invoke-virtual {v2, v14, v7, v8}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Ljava/util/ArrayList;Ljava/util/ArrayList;)V

    goto/16 :goto_0
.end method

.method static a(Landroid/support/v4/app/k;Ljava/util/ArrayList;Ljava/util/ArrayList;IIZ)V
    .locals 7
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/k;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/support/v4/app/b;",
            ">;",
            "Ljava/util/ArrayList",
            "<",
            "Ljava/lang/Boolean;",
            ">;IIZ)V"
        }
    .end annotation

    iget v0, p0, Landroid/support/v4/app/k;->l:I

    const/4 v1, 0x1

    if-ge v0, v1, :cond_1

    :cond_0
    return-void

    :cond_1
    new-instance v3, Landroid/util/SparseArray;

    invoke-direct {v3}, Landroid/util/SparseArray;-><init>()V

    move v2, p3

    :goto_0
    if-ge v2, p4, :cond_3

    invoke-virtual {p1, v2}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/support/v4/app/b;

    invoke-virtual {p2, v2}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v1

    check-cast v1, Ljava/lang/Boolean;

    invoke-virtual {v1}, Ljava/lang/Boolean;->booleanValue()Z

    move-result v1

    if-eqz v1, :cond_2

    invoke-static {v0, v3, p5}, Landroid/support/v4/app/p;->b(Landroid/support/v4/app/b;Landroid/util/SparseArray;Z)V

    :goto_1
    add-int/lit8 v0, v2, 0x1

    move v2, v0

    goto :goto_0

    :cond_2
    invoke-static {v0, v3, p5}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/b;Landroid/util/SparseArray;Z)V

    goto :goto_1

    :cond_3
    invoke-virtual {v3}, Landroid/util/SparseArray;->size()I

    move-result v0

    if-eqz v0, :cond_0

    new-instance v2, Landroid/view/View;

    iget-object v0, p0, Landroid/support/v4/app/k;->m:Landroid/support/v4/app/i;

    invoke-virtual {v0}, Landroid/support/v4/app/i;->g()Landroid/content/Context;

    move-result-object v0

    invoke-direct {v2, v0}, Landroid/view/View;-><init>(Landroid/content/Context;)V

    invoke-virtual {v3}, Landroid/util/SparseArray;->size()I

    move-result v4

    const/4 v0, 0x0

    move v1, v0

    :goto_2
    if-ge v1, v4, :cond_0

    invoke-virtual {v3, v1}, Landroid/util/SparseArray;->keyAt(I)I

    move-result v5

    invoke-static {v5, p1, p2, p3, p4}, Landroid/support/v4/app/p;->a(ILjava/util/ArrayList;Ljava/util/ArrayList;II)Landroid/support/v4/e/a;

    move-result-object v6

    invoke-virtual {v3, v1}, Landroid/util/SparseArray;->valueAt(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/support/v4/app/p$a;

    if-eqz p5, :cond_4

    invoke-static {p0, v5, v0, v2, v6}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/k;ILandroid/support/v4/app/p$a;Landroid/view/View;Landroid/support/v4/e/a;)V

    :goto_3
    add-int/lit8 v0, v1, 0x1

    move v1, v0

    goto :goto_2

    :cond_4
    invoke-static {p0, v5, v0, v2, v6}, Landroid/support/v4/app/p;->b(Landroid/support/v4/app/k;ILandroid/support/v4/app/p$a;Landroid/view/View;Landroid/support/v4/e/a;)V

    goto :goto_3
.end method

.method private static a(Landroid/support/v4/app/r;Landroid/view/ViewGroup;Landroid/support/v4/app/e;Landroid/view/View;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;)V
    .locals 9
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Landroid/view/ViewGroup;",
            "Landroid/support/v4/app/e;",
            "Landroid/view/View;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Ljava/lang/Object;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Ljava/lang/Object;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;)V"
        }
    .end annotation

    new-instance v0, Landroid/support/v4/app/p$2;

    move-object v1, p5

    move-object v2, p0

    move-object v3, p3

    move-object v4, p2

    move-object v5, p4

    move-object v6, p6

    move-object/from16 v7, p8

    move-object/from16 v8, p7

    invoke-direct/range {v0 .. v8}, Landroid/support/v4/app/p$2;-><init>(Ljava/lang/Object;Landroid/support/v4/app/r;Landroid/view/View;Landroid/support/v4/app/e;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/lang/Object;)V

    invoke-static {p1, v0}, Landroid/support/v4/app/t;->a(Landroid/view/View;Ljava/lang/Runnable;)Landroid/support/v4/app/t;

    return-void
.end method

.method private static a(Landroid/support/v4/app/r;Ljava/lang/Object;Landroid/support/v4/app/e;Ljava/util/ArrayList;)V
    .locals 2
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Ljava/lang/Object;",
            "Landroid/support/v4/app/e;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;)V"
        }
    .end annotation

    if-eqz p2, :cond_0

    if-eqz p1, :cond_0

    iget-boolean v0, p2, Landroid/support/v4/app/e;->l:Z

    if-eqz v0, :cond_0

    iget-boolean v0, p2, Landroid/support/v4/app/e;->B:Z

    if-eqz v0, :cond_0

    iget-boolean v0, p2, Landroid/support/v4/app/e;->P:Z

    if-eqz v0, :cond_0

    const/4 v0, 0x1

    invoke-virtual {p2, v0}, Landroid/support/v4/app/e;->f(Z)V

    invoke-virtual {p2}, Landroid/support/v4/app/e;->m()Landroid/view/View;

    move-result-object v0

    invoke-virtual {p0, p1, v0, p3}, Landroid/support/v4/app/r;->b(Ljava/lang/Object;Landroid/view/View;Ljava/util/ArrayList;)V

    iget-object v0, p2, Landroid/support/v4/app/e;->I:Landroid/view/ViewGroup;

    new-instance v1, Landroid/support/v4/app/p$1;

    invoke-direct {v1, p3}, Landroid/support/v4/app/p$1;-><init>(Ljava/util/ArrayList;)V

    invoke-static {v0, v1}, Landroid/support/v4/app/t;->a(Landroid/view/View;Ljava/lang/Runnable;)Landroid/support/v4/app/t;

    :cond_0
    return-void
.end method

.method private static a(Landroid/support/v4/app/r;Ljava/lang/Object;Ljava/lang/Object;Landroid/support/v4/e/a;ZLandroid/support/v4/app/b;)V
    .locals 2
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Ljava/lang/Object;",
            "Ljava/lang/Object;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Landroid/view/View;",
            ">;Z",
            "Landroid/support/v4/app/b;",
            ")V"
        }
    .end annotation

    const/4 v1, 0x0

    iget-object v0, p5, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    if-eqz v0, :cond_0

    iget-object v0, p5, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    invoke-virtual {v0}, Ljava/util/ArrayList;->isEmpty()Z

    move-result v0

    if-nez v0, :cond_0

    if-eqz p4, :cond_1

    iget-object v0, p5, Landroid/support/v4/app/b;->s:Ljava/util/ArrayList;

    invoke-virtual {v0, v1}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    :goto_0
    invoke-virtual {p3, v0}, Landroid/support/v4/e/a;->get(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/view/View;

    invoke-virtual {p0, p1, v0}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Landroid/view/View;)V

    if-eqz p2, :cond_0

    invoke-virtual {p0, p2, v0}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Landroid/view/View;)V

    :cond_0
    return-void

    :cond_1
    iget-object v0, p5, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    invoke-virtual {v0, v1}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    goto :goto_0
.end method

.method private static a(Landroid/support/v4/e/a;Landroid/support/v4/e/a;)V
    .locals 2
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Landroid/view/View;",
            ">;)V"
        }
    .end annotation

    invoke-virtual {p0}, Landroid/support/v4/e/a;->size()I

    move-result v0

    add-int/lit8 v0, v0, -0x1

    move v1, v0

    :goto_0
    if-ltz v1, :cond_1

    invoke-virtual {p0, v1}, Landroid/support/v4/e/a;->c(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    invoke-virtual {p1, v0}, Landroid/support/v4/e/a;->containsKey(Ljava/lang/Object;)Z

    move-result v0

    if-nez v0, :cond_0

    invoke-virtual {p0, v1}, Landroid/support/v4/e/a;->d(I)Ljava/lang/Object;

    :cond_0
    add-int/lit8 v0, v1, -0x1

    move v1, v0

    goto :goto_0

    :cond_1
    return-void
.end method

.method static a(Ljava/util/ArrayList;I)V
    .locals 2
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;I)V"
        }
    .end annotation

    if-nez p0, :cond_1

    :cond_0
    return-void

    :cond_1
    invoke-virtual {p0}, Ljava/util/ArrayList;->size()I

    move-result v0

    add-int/lit8 v0, v0, -0x1

    move v1, v0

    :goto_0
    if-ltz v1, :cond_0

    invoke-virtual {p0, v1}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/view/View;

    invoke-virtual {v0, p1}, Landroid/view/View;->setVisibility(I)V

    add-int/lit8 v0, v1, -0x1

    move v1, v0

    goto :goto_0
.end method

.method private static a(Ljava/util/ArrayList;Landroid/support/v4/e/a;Ljava/util/Collection;)V
    .locals 3
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Landroid/view/View;",
            ">;",
            "Ljava/util/Collection",
            "<",
            "Ljava/lang/String;",
            ">;)V"
        }
    .end annotation

    invoke-virtual {p1}, Landroid/support/v4/e/a;->size()I

    move-result v0

    add-int/lit8 v0, v0, -0x1

    move v1, v0

    :goto_0
    if-ltz v1, :cond_1

    invoke-virtual {p1, v1}, Landroid/support/v4/e/a;->c(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/view/View;

    invoke-static {v0}, Landroid/support/v4/f/t;->i(Landroid/view/View;)Ljava/lang/String;

    move-result-object v2

    invoke-interface {p2, v2}, Ljava/util/Collection;->contains(Ljava/lang/Object;)Z

    move-result v2

    if-eqz v2, :cond_0

    invoke-virtual {p0, v0}, Ljava/util/ArrayList;->add(Ljava/lang/Object;)Z

    :cond_0
    add-int/lit8 v0, v1, -0x1

    move v1, v0

    goto :goto_0

    :cond_1
    return-void
.end method

.method private static a(Landroid/support/v4/app/r;Ljava/util/List;)Z
    .locals 4
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Ljava/util/List",
            "<",
            "Ljava/lang/Object;",
            ">;)Z"
        }
    .end annotation

    const/4 v0, 0x0

    invoke-interface {p1}, Ljava/util/List;->size()I

    move-result v2

    move v1, v0

    :goto_0
    if-ge v1, v2, :cond_1

    invoke-interface {p1, v1}, Ljava/util/List;->get(I)Ljava/lang/Object;

    move-result-object v3

    invoke-virtual {p0, v3}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;)Z

    move-result v3

    if-nez v3, :cond_0

    :goto_1
    return v0

    :cond_0
    add-int/lit8 v1, v1, 0x1

    goto :goto_0

    :cond_1
    const/4 v0, 0x1

    goto :goto_1
.end method

.method private static b(Landroid/support/v4/app/r;Landroid/support/v4/e/a;Ljava/lang/Object;Landroid/support/v4/app/p$a;)Landroid/support/v4/e/a;
    .locals 6
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;",
            "Ljava/lang/Object;",
            "Landroid/support/v4/app/p$a;",
            ")",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Landroid/view/View;",
            ">;"
        }
    .end annotation

    invoke-virtual {p1}, Landroid/support/v4/e/a;->isEmpty()Z

    move-result v0

    if-nez v0, :cond_0

    if-nez p2, :cond_1

    :cond_0
    invoke-virtual {p1}, Landroid/support/v4/e/a;->clear()V

    const/4 v0, 0x0

    :goto_0
    return-object v0

    :cond_1
    iget-object v0, p3, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    new-instance v3, Landroid/support/v4/e/a;

    invoke-direct {v3}, Landroid/support/v4/e/a;-><init>()V

    invoke-virtual {v0}, Landroid/support/v4/app/e;->m()Landroid/view/View;

    move-result-object v1

    invoke-virtual {p0, v3, v1}, Landroid/support/v4/app/r;->a(Ljava/util/Map;Landroid/view/View;)V

    iget-object v2, p3, Landroid/support/v4/app/p$a;->f:Landroid/support/v4/app/b;

    iget-boolean v1, p3, Landroid/support/v4/app/p$a;->e:Z

    if-eqz v1, :cond_3

    invoke-virtual {v0}, Landroid/support/v4/app/e;->T()Landroid/support/v4/app/u;

    move-result-object v1

    iget-object v0, v2, Landroid/support/v4/app/b;->s:Ljava/util/ArrayList;

    move-object v2, v0

    :goto_1
    invoke-virtual {v3, v2}, Landroid/support/v4/e/a;->a(Ljava/util/Collection;)Z

    if-eqz v1, :cond_5

    invoke-virtual {v1, v2, v3}, Landroid/support/v4/app/u;->a(Ljava/util/List;Ljava/util/Map;)V

    invoke-virtual {v2}, Ljava/util/ArrayList;->size()I

    move-result v0

    add-int/lit8 v0, v0, -0x1

    move v4, v0

    :goto_2
    if-ltz v4, :cond_6

    invoke-virtual {v2, v4}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    invoke-virtual {v3, v0}, Landroid/support/v4/e/a;->get(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v1

    check-cast v1, Landroid/view/View;

    if-nez v1, :cond_4

    invoke-virtual {p1, v0}, Landroid/support/v4/e/a;->remove(Ljava/lang/Object;)Ljava/lang/Object;

    :cond_2
    :goto_3
    add-int/lit8 v0, v4, -0x1

    move v4, v0

    goto :goto_2

    :cond_3
    invoke-virtual {v0}, Landroid/support/v4/app/e;->U()Landroid/support/v4/app/u;

    move-result-object v1

    iget-object v0, v2, Landroid/support/v4/app/b;->r:Ljava/util/ArrayList;

    move-object v2, v0

    goto :goto_1

    :cond_4
    invoke-static {v1}, Landroid/support/v4/f/t;->i(Landroid/view/View;)Ljava/lang/String;

    move-result-object v5

    invoke-virtual {v0, v5}, Ljava/lang/String;->equals(Ljava/lang/Object;)Z

    move-result v5

    if-nez v5, :cond_2

    invoke-virtual {p1, v0}, Landroid/support/v4/e/a;->remove(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Ljava/lang/String;

    invoke-static {v1}, Landroid/support/v4/f/t;->i(Landroid/view/View;)Ljava/lang/String;

    move-result-object v1

    invoke-virtual {p1, v1, v0}, Landroid/support/v4/e/a;->put(Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    goto :goto_3

    :cond_5
    invoke-virtual {v3}, Landroid/support/v4/e/a;->keySet()Ljava/util/Set;

    move-result-object v0

    invoke-virtual {p1, v0}, Landroid/support/v4/e/a;->a(Ljava/util/Collection;)Z

    :cond_6
    move-object v0, v3

    goto :goto_0
.end method

.method private static b(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Z)Ljava/lang/Object;
    .locals 1

    if-nez p1, :cond_0

    const/4 v0, 0x0

    :goto_0
    return-object v0

    :cond_0
    if-eqz p2, :cond_1

    invoke-virtual {p1}, Landroid/support/v4/app/e;->x()Ljava/lang/Object;

    move-result-object v0

    :goto_1
    invoke-virtual {p0, v0}, Landroid/support/v4/app/r;->b(Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v0

    goto :goto_0

    :cond_1
    invoke-virtual {p1}, Landroid/support/v4/app/e;->y()Ljava/lang/Object;

    move-result-object v0

    goto :goto_1
.end method

.method private static b(Landroid/support/v4/app/r;Landroid/view/ViewGroup;Landroid/view/View;Landroid/support/v4/e/a;Landroid/support/v4/app/p$a;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;
    .locals 18
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/r;",
            "Landroid/view/ViewGroup;",
            "Landroid/view/View;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;",
            "Landroid/support/v4/app/p$a;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Ljava/util/ArrayList",
            "<",
            "Landroid/view/View;",
            ">;",
            "Ljava/lang/Object;",
            "Ljava/lang/Object;",
            ")",
            "Ljava/lang/Object;"
        }
    .end annotation

    move-object/from16 v0, p4

    iget-object v12, v0, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    move-object/from16 v0, p4

    iget-object v13, v0, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    if-eqz v12, :cond_0

    if-nez v13, :cond_1

    :cond_0
    const/4 v4, 0x0

    :goto_0
    return-object v4

    :cond_1
    move-object/from16 v0, p4

    iget-boolean v14, v0, Landroid/support/v4/app/p$a;->b:Z

    invoke-virtual/range {p3 .. p3}, Landroid/support/v4/e/a;->isEmpty()Z

    move-result v3

    if-eqz v3, :cond_2

    const/4 v3, 0x0

    :goto_1
    move-object/from16 v0, p0

    move-object/from16 v1, p3

    move-object/from16 v2, p4

    invoke-static {v0, v1, v3, v2}, Landroid/support/v4/app/p;->b(Landroid/support/v4/app/r;Landroid/support/v4/e/a;Ljava/lang/Object;Landroid/support/v4/app/p$a;)Landroid/support/v4/e/a;

    move-result-object v6

    invoke-virtual/range {p3 .. p3}, Landroid/support/v4/e/a;->isEmpty()Z

    move-result v4

    if-eqz v4, :cond_3

    const/4 v4, 0x0

    :goto_2
    if-nez p7, :cond_4

    if-nez p8, :cond_4

    if-nez v4, :cond_4

    const/4 v4, 0x0

    goto :goto_0

    :cond_2
    move-object/from16 v0, p0

    invoke-static {v0, v12, v13, v14}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v3

    goto :goto_1

    :cond_3
    invoke-virtual {v6}, Landroid/support/v4/e/a;->values()Ljava/util/Collection;

    move-result-object v4

    move-object/from16 v0, p5

    invoke-virtual {v0, v4}, Ljava/util/ArrayList;->addAll(Ljava/util/Collection;)Z

    move-object v4, v3

    goto :goto_2

    :cond_4
    const/4 v3, 0x1

    invoke-static {v12, v13, v14, v6, v3}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/e;Landroid/support/v4/app/e;ZLandroid/support/v4/e/a;Z)V

    if-eqz v4, :cond_6

    new-instance v17, Landroid/graphics/Rect;

    invoke-direct/range {v17 .. v17}, Landroid/graphics/Rect;-><init>()V

    move-object/from16 v0, p0

    move-object/from16 v1, p2

    move-object/from16 v2, p5

    invoke-virtual {v0, v4, v1, v2}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Landroid/view/View;Ljava/util/ArrayList;)V

    move-object/from16 v0, p4

    iget-boolean v7, v0, Landroid/support/v4/app/p$a;->e:Z

    move-object/from16 v0, p4

    iget-object v8, v0, Landroid/support/v4/app/p$a;->f:Landroid/support/v4/app/b;

    move-object/from16 v3, p0

    move-object/from16 v5, p8

    invoke-static/range {v3 .. v8}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Ljava/lang/Object;Landroid/support/v4/e/a;ZLandroid/support/v4/app/b;)V

    if-eqz p7, :cond_5

    move-object/from16 v0, p0

    move-object/from16 v1, p7

    move-object/from16 v2, v17

    invoke-virtual {v0, v1, v2}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Landroid/graphics/Rect;)V

    :cond_5
    :goto_3
    new-instance v5, Landroid/support/v4/app/p$4;

    move-object/from16 v6, p0

    move-object/from16 v7, p3

    move-object v8, v4

    move-object/from16 v9, p4

    move-object/from16 v10, p6

    move-object/from16 v11, p2

    move-object/from16 v15, p5

    move-object/from16 v16, p7

    invoke-direct/range {v5 .. v17}, Landroid/support/v4/app/p$4;-><init>(Landroid/support/v4/app/r;Landroid/support/v4/e/a;Ljava/lang/Object;Landroid/support/v4/app/p$a;Ljava/util/ArrayList;Landroid/view/View;Landroid/support/v4/app/e;Landroid/support/v4/app/e;ZLjava/util/ArrayList;Ljava/lang/Object;Landroid/graphics/Rect;)V

    move-object/from16 v0, p1

    invoke-static {v0, v5}, Landroid/support/v4/app/t;->a(Landroid/view/View;Ljava/lang/Runnable;)Landroid/support/v4/app/t;

    goto :goto_0

    :cond_6
    const/16 v17, 0x0

    goto :goto_3
.end method

.method public static b(Landroid/support/v4/app/b;Landroid/util/SparseArray;Z)V
    .locals 3
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/b;",
            "Landroid/util/SparseArray",
            "<",
            "Landroid/support/v4/app/p$a;",
            ">;Z)V"
        }
    .end annotation

    iget-object v0, p0, Landroid/support/v4/app/b;->a:Landroid/support/v4/app/k;

    iget-object v0, v0, Landroid/support/v4/app/k;->n:Landroid/support/v4/app/g;

    invoke-virtual {v0}, Landroid/support/v4/app/g;->a()Z

    move-result v0

    if-nez v0, :cond_1

    :cond_0
    return-void

    :cond_1
    iget-object v0, p0, Landroid/support/v4/app/b;->b:Ljava/util/ArrayList;

    invoke-virtual {v0}, Ljava/util/ArrayList;->size()I

    move-result v0

    add-int/lit8 v0, v0, -0x1

    move v1, v0

    :goto_0
    if-ltz v1, :cond_0

    iget-object v0, p0, Landroid/support/v4/app/b;->b:Ljava/util/ArrayList;

    invoke-virtual {v0, v1}, Ljava/util/ArrayList;->get(I)Ljava/lang/Object;

    move-result-object v0

    check-cast v0, Landroid/support/v4/app/b$a;

    const/4 v2, 0x1

    invoke-static {p0, v0, p1, v2, p2}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/b;Landroid/support/v4/app/b$a;Landroid/util/SparseArray;ZZ)V

    add-int/lit8 v0, v1, -0x1

    move v1, v0

    goto :goto_0
.end method

.method private static b(Landroid/support/v4/app/k;ILandroid/support/v4/app/p$a;Landroid/view/View;Landroid/support/v4/e/a;)V
    .locals 29
    .annotation system Ldalvik/annotation/Signature;
        value = {
            "(",
            "Landroid/support/v4/app/k;",
            "I",
            "Landroid/support/v4/app/p$a;",
            "Landroid/view/View;",
            "Landroid/support/v4/e/a",
            "<",
            "Ljava/lang/String;",
            "Ljava/lang/String;",
            ">;)V"
        }
    .end annotation

    const/4 v2, 0x0

    move-object/from16 v0, p0

    iget-object v1, v0, Landroid/support/v4/app/k;->n:Landroid/support/v4/app/g;

    invoke-virtual {v1}, Landroid/support/v4/app/g;->a()Z

    move-result v1

    if-eqz v1, :cond_0

    move-object/from16 v0, p0

    iget-object v1, v0, Landroid/support/v4/app/k;->n:Landroid/support/v4/app/g;

    move/from16 v0, p1

    invoke-virtual {v1, v0}, Landroid/support/v4/app/g;->a(I)Landroid/view/View;

    move-result-object v1

    check-cast v1, Landroid/view/ViewGroup;

    move-object v2, v1

    :cond_0
    if-nez v2, :cond_2

    :cond_1
    :goto_0
    return-void

    :cond_2
    move-object/from16 v0, p2

    iget-object v13, v0, Landroid/support/v4/app/p$a;->a:Landroid/support/v4/app/e;

    move-object/from16 v0, p2

    iget-object v10, v0, Landroid/support/v4/app/p$a;->d:Landroid/support/v4/app/e;

    invoke-static {v10, v13}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/e;Landroid/support/v4/app/e;)Landroid/support/v4/app/r;

    move-result-object v1

    if-eqz v1, :cond_1

    move-object/from16 v0, p2

    iget-boolean v3, v0, Landroid/support/v4/app/p$a;->b:Z

    move-object/from16 v0, p2

    iget-boolean v4, v0, Landroid/support/v4/app/p$a;->e:Z

    invoke-static {v1, v13, v3}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v8

    invoke-static {v1, v10, v4}, Landroid/support/v4/app/p;->b(Landroid/support/v4/app/r;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v9

    new-instance v6, Ljava/util/ArrayList;

    invoke-direct {v6}, Ljava/util/ArrayList;-><init>()V

    new-instance v7, Ljava/util/ArrayList;

    invoke-direct {v7}, Ljava/util/ArrayList;-><init>()V

    move-object/from16 v3, p3

    move-object/from16 v4, p4

    move-object/from16 v5, p2

    invoke-static/range {v1 .. v9}, Landroid/support/v4/app/p;->b(Landroid/support/v4/app/r;Landroid/view/ViewGroup;Landroid/view/View;Landroid/support/v4/e/a;Landroid/support/v4/app/p$a;Ljava/util/ArrayList;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/lang/Object;)Ljava/lang/Object;

    move-result-object v12

    if-nez v8, :cond_3

    if-nez v12, :cond_3

    if-eqz v9, :cond_1

    :cond_3
    move-object/from16 v0, p3

    invoke-static {v1, v9, v10, v6, v0}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Landroid/support/v4/app/e;Ljava/util/ArrayList;Landroid/view/View;)Ljava/util/ArrayList;

    move-result-object v19

    if-eqz v19, :cond_4

    invoke-virtual/range {v19 .. v19}, Ljava/util/ArrayList;->isEmpty()Z

    move-result v3

    if-eqz v3, :cond_5

    :cond_4
    const/4 v11, 0x0

    :goto_1
    move-object/from16 v0, p3

    invoke-virtual {v1, v8, v0}, Landroid/support/v4/app/r;->b(Ljava/lang/Object;Landroid/view/View;)V

    move-object/from16 v0, p2

    iget-boolean v14, v0, Landroid/support/v4/app/p$a;->b:Z

    move-object v9, v1

    move-object v10, v8

    invoke-static/range {v9 .. v14}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Ljava/lang/Object;Ljava/lang/Object;Ljava/lang/Object;Landroid/support/v4/app/e;Z)Ljava/lang/Object;

    move-result-object v15

    if-eqz v15, :cond_1

    new-instance v17, Ljava/util/ArrayList;

    invoke-direct/range {v17 .. v17}, Ljava/util/ArrayList;-><init>()V

    move-object v14, v1

    move-object/from16 v16, v8

    move-object/from16 v18, v11

    move-object/from16 v20, v12

    move-object/from16 v21, v7

    invoke-virtual/range {v14 .. v21}, Landroid/support/v4/app/r;->a(Ljava/lang/Object;Ljava/lang/Object;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;)V

    move-object/from16 v20, v1

    move-object/from16 v21, v2

    move-object/from16 v22, v13

    move-object/from16 v23, p3

    move-object/from16 v24, v7

    move-object/from16 v25, v8

    move-object/from16 v26, v17

    move-object/from16 v27, v11

    move-object/from16 v28, v19

    invoke-static/range {v20 .. v28}, Landroid/support/v4/app/p;->a(Landroid/support/v4/app/r;Landroid/view/ViewGroup;Landroid/support/v4/app/e;Landroid/view/View;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;Ljava/lang/Object;Ljava/util/ArrayList;)V

    move-object/from16 v0, p4

    invoke-virtual {v1, v2, v7, v0}, Landroid/support/v4/app/r;->a(Landroid/view/View;Ljava/util/ArrayList;Ljava/util/Map;)V

    invoke-virtual {v1, v2, v15}, Landroid/support/v4/app/r;->a(Landroid/view/ViewGroup;Ljava/lang/Object;)V

    move-object/from16 v0, p4

    invoke-virtual {v1, v2, v7, v0}, Landroid/support/v4/app/r;->a(Landroid/view/ViewGroup;Ljava/util/ArrayList;Ljava/util/Map;)V

    goto/16 :goto_0

    :cond_5
    move-object v11, v9

    goto :goto_1
.end method
